<?php

namespace Prismic\PrismicStarterProjectBundle\Helper;

use Symfony\Component\Routing\Router;

use Prismic\Api;
use Prismic\Ref;
use Prismic\LinkResolver;

class LocalLinkResolver extends LinkResolver
{

    private $router; 
    private $api;
    private $maybeRef;

    public function __construct(Router $router, Api $api, Ref $maybeRef = null)
    {
        $this->router = $router;
        $this->api = $api;
        $this->maybeRef = $maybeRef;
    }

    public function resolve($link) 
    {
        return $this->router->generate('detail', array('id' => $link->getId(), 'slug' => $link->getSlug(), 'ref' => $this->maybeRef));
    }

}
