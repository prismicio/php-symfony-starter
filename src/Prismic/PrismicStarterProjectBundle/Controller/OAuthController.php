<?php

namespace Prismic\PrismicStarterProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Prismic\Api;

class OAuthController extends Controller
{

    /**
     * @Route("/signin", name="signin")
     */
    public function signinAction()
    {
        $prismic = $this->get('prismic.helper');

        return $this->redirect(
            $prismic->getApiHome()->oauthInitiateEndpoint().'?'.http_build_query(
                array(
                    "client_id" => $prismic->getClientId(),
                    "redirect_uri" => $this->generateUrl('auth_callback', array(), true),
                    "scope" => "master+releases"
                )
            )
        );
    }

    /**
     * @Route("/auth_callback", name="auth_callback")
     */ 
    public function callbackAction() 
    {
        $prismic = $this->get('prismic.helper');

        $data = array(
            "grant_type" => "authorization_code",
            "code" => $this->getRequest()->query->get('code'),
            "redirect_uri" => $this->generateUrl('auth_callback', array(), true),
            "client_id" => $prismic->getClientId(),
            "client_secret" => $prismic->getClientSecret()
        );

        $conn = curl_init();
        curl_setopt($conn, CURLOPT_URL, $prismic->getApiHome()->oauthTokenEndpoint());
        curl_setopt($conn, CURLOPT_POST, true);
        curl_setopt($conn, CURLOPT_POSTFIELDS, $data);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);

        $accessToken = json_decode(curl_exec($conn))->{'access_token'};

        $this->getRequest()->getSession()->set('ACCESS_TOKEN', $accessToken);

        return $this->redirect(
            $this->generateUrl('home')
        );
    }

    /**
     * @Route("/signout", name="signout")
     */ 
    public function signout() 
    {
        $this->getRequest()->getSession()->clear();

        return $this->redirect(
            $this->generateUrl('home')
        );
    }

}
