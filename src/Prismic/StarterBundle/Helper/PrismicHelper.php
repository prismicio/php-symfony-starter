<?php

namespace Prismic\StarterBundle\Helper;

use Prismic\Api;

class PrismicHelper
{

    protected $apiEndpoint;
    protected $accessToken;

    public function __construct($apiEndpoint, $accessToken)
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->accessToken = $accessToken;
    }

    public function getApiHome($customAccessToken = null) 
    {
        $api = Api::get($this->apiEndpoint, $customAccessToken ? $customAccessToken : $this->accessToken);
        return $api;
    }

}
