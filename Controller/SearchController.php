<?php

namespace Purjus\SearchBundle\Controller;


use Purjus\SymfonyBundle\Controller\PurjusController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Purjus\SearchBundle\Event\SearchEvent;
use Purjus\SearchBundle\Event\PurjusSearchEvents;
use Purjus\SearchBundle\Manager\SearchManager;

/**
 * Search controller.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchController extends PurjusController
{

    /**
     * @Method({"GET", "POST"})
     * @Route("/result/{term}", name="purjus_search")
     * @param Request $request
     */
    public function searchAction(Request $request, $term)
    {

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->get('event_dispatcher');

        $event = new SearchEvent($term);

        $dispatcher->dispatch(PurjusSearchEvents::SEARCH_BEGIN, $event);

        /** @var SearchManager $manager */
        $manager = $this->get('purjus_search.manager');
        $manager->setTerm($term);

        $results = $manager->getResults();
        $event->setResults($results);

        $dispatcher->dispatch(PurjusSearchEvents::SEARCH_END, $event);

        return new JsonResponse($results);

    }

}
