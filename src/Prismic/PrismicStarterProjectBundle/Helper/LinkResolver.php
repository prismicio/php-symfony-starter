<?php

namespace Prismic\PrismicStarterProjectBundle\Helper;

use Symfony\Component\Routing\Router;

use Prismic\Api;

class LinkResolver
{

    private $router; 

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function resolve($link, $api, $maybeRef) 
    {
        return $this->router->generate('detail', array('id' => $link->getId(), 'slug' => $link->getSlug(), 'ref' => $maybeRef));
    }

}
