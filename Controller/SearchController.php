<?php

namespace Purjus\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Purjus\SearchBundle\Manager\SearchManager;
use FOS\RestBundle\Controller\Annotations\NoRoute;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Purjus\AdminBundle\Controller\PurjusTranslatableRESTController;


/**
 * Search controller.
 *
 * @author Purjus Communication
 * @author Tom
 *
 *
 */
class SearchController extends PurjusTranslatableRESTController
{

    /**
     * Display results or send them serialized.
     *
     * @NoRoute
     *
     * @param Request $request
     * @return Response|array
     */
    public function searchAction(Request $request, $term)
    {

        $results = $this->getResults($request, $term);

        $view = $this->view($results, 200)
            ->setTemplate('PurjusSearchBundle:Search:search.html.twig')
            ->setTemplateVar('results') // name of the "main" variable in the template
            ->setTemplateData(array(
                'term' => $term,
                'lang_alternates' => $this->getGenericLangAlternates($request, array('term' => $term)),
            ));

        return $this->handleView($view);

    }

    /**
     * The search block. Get the term from the search manager.
     *
     * @NoRoute
     *
     * @return Response
     */
    public function renderBlockSearchAction()
    {
        return $this->renderBlockSearch(
            'PurjusSearchBundle:Block:search.html.twig',
            'purjus_search_post',
            array('term' => $this->get('purjus_search.manager')->getTerm())
        );
    }

    /**
     * Global search in the website
     *
     * @Post("search")
     * @RequestParam(name="term", requirements="[a-z]", allowBlank=false, description="The term")
     * @RequestParam(name="domains", requirements=".+", allowBlank=false, nullable=true, description="Domains to be included")
     *
     * @ApiDoc()
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return Response
     */
    public function postSearchAction(Request $request, ParamFetcher $paramFetcher)
    {

        $term = $paramFetcher->get('term');

        // if the form is posted, redirect to the GET route with the term in the query
        if ('html' === $request->getRequestFormat()) {
            $view = $this->routeRedirectView('purjus_search', array('term' => $term), 301);
            return $this->handleView($view);
        }

        return $this->forward('PurjusSearchBundle:Search:search', array(
            'request' => $request,
            'term'  => $term,
        ));

    }

    /**
     * Get results
     *
     * @param Request $request
     * @param unknown $term
     * @return \Purjus\SearchBundle\Manager\Group[]
     */
    protected function getResults(Request $request, $term)
    {

        if (strlen($term) < $this->getParameter('purjus_search.min_length')) {
            return array();
        }

        /** @var SearchManager $manager */
        $manager = $this->get('purjus_search.manager');

        $domains = (array) $request->get('domains');

        return $manager->search($term, array(
            'max_entries' => $this->getParameter('purjus_search.max_entries'),
            'domains' => $domains,
        ));

    }


}
