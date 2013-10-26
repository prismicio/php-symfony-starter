<?php

namespace Prismic\PrismicStarterProjectBundle\Helper;

use Prismic\Api;
use Prismic\Fragment\Link\DocumentLink;
use Symfony\Component\HttpFoundation\Request;

class PrismicContext
{
    private $accessToken;
    private $api;
    private $masterRef;
    private $ref;
    private $maybeRef;
    private $linkResolverRules;

    public function __construct(PrismicHelper $prismic, LinkResolver $linkResolverRules)
    {
        $this->api = $prismic->getApiHome($this->accessToken);
        $this->masterRef = $this->api->master()->getRef();
        $this->linkResolverRules = $linkResolverRules;
    }

    public function setRequest(Request $request = null)
    {
        $this->accessToken = $request->getSession()->get('ACCESS_TOKEN');
        $this->ref         = $request->query->get('ref', $this->masterRef);
        $this->maybeRef    = $this->ref === $this->masterRef ? null : $this->ref;
    }

    public function hasPrivilegedAccess()
    {
        return isset($this->accessToken);
    }

    public function getApi()
    {
        return $this->api;
    }

    public function getRef()
    {
        return $this->ref;
    }

    public function getMasterRef()
    {
        return $this->masterRef;
    }

    public function maybeRef()
    {
        return $this->maybeRef;
    }

    public function linkResolver() 
    {
        $self = $this;

        return function($link) use ($self) {
            return $self->linkResolverRules->resolve($link, $self->api, $self->maybeRef);
        };
    }

    public function resolveLink($doc) 
    {
        return $this->linkResolverRules->resolve(new DocumentLink($doc->getId(), $doc->getType(), $doc->getTags(), $doc->slug(), false), $this->api, $this->maybeRef);
    }

    public function getDocument($id) 
    {
        $docs = $this->api->forms()->everything->ref($this->getRef())->query(
            '[[:d = at(document.id, "'.$id.'")]]'
        )->submit();

        if (is_array($docs) && count($docs) > 0) {
            return $docs[0];
        }

        return null;
    }
}
