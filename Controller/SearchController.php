<?php

namespace Purjus\SearchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Purjus\SearchBundle\Event\SearchEvent;
use Purjus\SearchBundle\Event\PurjusSearchEvents;
use Purjus\SearchBundle\Manager\SearchManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Purjus\SymfonyBundle\Controller\PurjusTranslatableController;

/**
 * Search controller.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchController extends PurjusTranslatableController
{

    /**
     * Display results or send them serialized.
     *
     * @Method({"GET", "POST"})
     * @Route("/{term}", name="purjus_search")
     * @Template()
     *
     * @param Request $request
     * @param $term
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

        $params = array(
            'term' => $term,
            'results' => $this->get('serializer')->normalize($results),
            'lang_alternates' => $this->getLangAlternates($request, $term),
        );

        return $this->render('PurjusSearchBundle:Search:search.html.twig', $params);

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
     * Get lang alternate for a search term,
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
