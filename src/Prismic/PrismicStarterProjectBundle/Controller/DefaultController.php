<?php

namespace Prismic\PrismicStarterProjectBundle\Controller;

use Prismic\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $ctx  = $this->get('prismic.context');
        $docs = $ctx->getApi()->forms()->everything->ref($ctx->getRef())->submit();

        return array(
            'ctx'  => $ctx,
            'docs' => $docs
        );
    }

    /**
     * @Route("/documents/{id}/{slug}", name="detail")
     * @Template()
     */
    public function detailAction($id, $slug)
    {
        $ctx = $this->get('prismic.context');
        $doc = $ctx->getDocument($id);

        if ($doc) {
            if ($slug === $doc->slug()) {
                return array(
                    'ctx' => $ctx,
                    'doc' => $doc
                );
            }

            if ($doc->containsSlug($slug)) {
                return $this->redirect(
                    $this->generateUrl('detail', array('id' => $id, 'slug' => $doc->slug(), 'ref' => $ctx->maybeRef()))
                );
            }
        }

        throw $this->createNotFoundException('Document not found');
    }

    /**
     * @Route("/search", name="search")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $q    = $request->query->get('q');
        $ctx  = $this->get('prismic.context');
        $docs = $ctx->getApi()->forms()->everything->ref($ctx->getRef())->query(
            '[[:d = fulltext(document, "'.$q.'")]]'
        )->submit();

        return array(
            'ctx'  => $ctx,
            'docs' => $docs
        );
    }
}
