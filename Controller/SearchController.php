<?php

namespace Purjus\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Purjus\SearchBundle\Event\SearchEvent;
use Purjus\SearchBundle\Event\PurjusSearchEvents;
use Purjus\SearchBundle\Manager\SearchManager;
use FOS\RestBundle\Controller\Annotations\Get;
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

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->get('event_dispatcher');

        $event = new SearchEvent($term);
        $dispatcher->dispatch(PurjusSearchEvents::SEARCH_BEGIN, $event);

        $results = $this->getResults($request, $term);

        $event->setResults($results); // set result in the event, so we can interact
        $dispatcher->dispatch(PurjusSearchEvents::SEARCH_END, $event);

        $view = $this->view($results, 200)
            ->setTemplate('PurjusSearchBundle:Search:search.html.twig')
            ->setTemplateVar('results') // name of the variable in the template
            ->setTemplateData(array(
                'term' => $term,
                'lang_alternates' => $this->getLangAlternates($request, $term),
            ));

        return $this->handleView($view);

    }

    /**
     *
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

        /** @var SearchManager $manager */
        $manager = $this->get('purjus_search.manager');

        $domains = (array) $request->get('domains');

        return $manager->getResults($term, array(
            'max_entries' => $this->getParameter('purjus_search.max_entries'),
            'domains' => $domains,
        ));

    }

    /**
     * Get lang alternates for a search term,
     * keeping all query paramers
     *
     * @param Request $request
     * @param unknown $term
     * @return array[hrefLang] = href
     */
    protected function getLangAlternates(Request $request, $term)
    {

        $router = $this->get('router');
        $params = $request->query->all();

        $alternates = array();
        foreach ($this->getTranslatablesLocales($request->getLocale()) as $locale) {
            $alternates[$locale] = $router->generate('purjus_search', array_merge(
                array('term' => $term, '_locale' => $locale),
                $params
            ));
        }

        return $alternates;

    }

}
