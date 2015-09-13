<?php

namespace Purjus\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Purjus\SearchBundle\Manager\SearchManager;
use FOS\RestBundle\Controller\Annotations\NoRoute;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
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
     * @Post("search")
     * @RequestParam(name="term", requirements=".+", allowBlank=false, strict=true, description="Search term.")
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postSearchAction(Request $request, ParamFetcher $paramFetcher)
    {
        $response = $this->forward('PurjusSearchBundle:Search:search', array(
            'term'  => $paramFetcher->get('term'),
        ));

        return $response;
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
