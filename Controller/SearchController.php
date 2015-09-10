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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * Display results or send them serialized.
     *
     * @Method({"GET", "POST"})
     * @Route("/result/{term}", name="purjus_search")
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

        /** @var SearchManager $manager */
        $manager = $this->get('purjus_search.manager');

        $results = $manager->getResults($term, array(
            'min_length' => $this->getParameter('purjus_search.min_length'),
            'max_entries' => $this->getParameter('purjus_search.max_entries'),
        ));

        $event->setResults($results); // set result in the event, so we can interract
        $dispatcher->dispatch(PurjusSearchEvents::SEARCH_END, $event);

        $params = array('results' => $this->get('serializer')->normalize($results));

        return $this->render('PurjusSearchBundle:Search:search.html.twig', $params);

    }

}
