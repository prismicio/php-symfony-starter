<?php

namespace Prismic\StarterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Prismic\Api;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $api = Api::get('https://lesbonneschoses.prismic.io/api');
        $ref = $this->getRequest()->query->get('ref',  $api->master()->ref);
        $docs = $api->forms()->everything->ref($ref)->submit();

        return array(
            'ref' => $ref,
            'docs' => $docs
        );
    }

    /**
     * @Route("/documents/{id}/{slug}", name="detail")
     * @Template()
     */
    public function detailAction($id, $slug)
    {

    }

    /**
     * @Route("/search", name="search")
     * @Template()
     */
    public function searchAction($q) 
    {

    }

}
