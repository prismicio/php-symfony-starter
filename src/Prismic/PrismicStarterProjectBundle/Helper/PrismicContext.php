<?php

namespace Prismic\PrismicStarterProjectBundle\Helper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

use Prismic\Api;
use Prismic\Fragment\Link\DocumentLink;
use Prismic\LinkResolver;

class PrismicContext
{

    private $accessToken;
    private $api;
    private $masterRef;
    private $ref;
    private $maybeRef;
    private $router;
    
    public function __construct(Request $request, PrismicHelper $prismic, Router $router)
    {
        $this->accessToken = $request->getSession()->get('ACCESS_TOKEN');
        $this->api = $prismic->getApiHome($this->accessToken);
        $this->masterRef = $this->api->master()->getRef();
        $this->ref = $request->query->get('ref', $this->masterRef);
        $this->maybeRef = $this->ref == $this->masterRef ? null : $this->ref;
        $this->router = $router;
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
        return new LocalLinkResolver($this->router, $this->api, $this->maybeRef);
    }

    public function resolveLink($doc) 
    {
        $link = new DocumentLink($doc->getId(), $doc->getType(), $doc->getTags(), $doc->getSlug(), false);
        return $this->linkResolver()->resolve($link);
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
