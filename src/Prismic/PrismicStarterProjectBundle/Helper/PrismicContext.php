<?php

namespace Prismic\PrismicStarterProjectBundle\Helper;

use Symfony\Component\HttpFoundation\Request;

use Prismic\Api;
use Prismic\Fragment\Link\DocumentLink;

class PrismicContext
{

    private $accessToken;
    private $api;
    private $masterRef;
    private $ref;
    private $maybeRef;
    private $linkResolverRules;
    
    public function __construct(Request $request, PrismicHelper $prismic, LinkResolver $linkResolverRules)
    {
        $this->accessToken = $request->getSession()->get('ACCESS_TOKEN');
        $this->api = $prismic->getApiHome($this->accessToken);
        $this->masterRef = $this->api->master()->getRef();
        $this->ref = $request->query->get('ref', $this->masterRef);
        $this->maybeRef = $this->ref == $this->masterRef ? null : $this->ref;
        $this->linkResolverRules = $linkResolverRules;
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
        return function($link) 
        {
            return $this->linkResolverRules->resolve($link, $this->api, $this->maybeRef);
        };
    }

    public function resolveLink($doc) 
    {
        $link = new DocumentLink($doc->getId(), $doc->getType(), $doc->getTags(), $doc->slug(), false);
        return $this->linkResolverRules->resolve($link, $this->api, $this->maybeRef);
    }

    public function getDocument($id) 
    {
        $docs = $this->getApi()->forms()->everything->ref($this->getRef())->query(
            '[[:d = at(document.id, "'.$id.'")]]'
        )->submit();

        if(is_array($docs) && count($docs) > 0) {
            return $docs[0];
        } else {
            return null;
        }
    }

}
