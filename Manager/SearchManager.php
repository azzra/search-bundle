<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Model\SearcherManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Purjus\SearchBundle\Event\SearchEvent;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;

/**
 * Search manager. Will call all the searcher.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchManager implements SearcherManagerInterface
{

    /**
     * @var EventDispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     * @var integer Minimum length of a search term
     */
    protected $minLength;

    /**
     * @var integer Maximum entries
     */
    protected $maxEntries;

    /**
     * @var \Purjus\SearchBundle\Model\SearcherInterface[] Searchers
     */
    protected $searchers = array();

    /**
     * @var \Purjus\SearchBundle\Entity\Group[] Search results
     */
    protected $results = array();


    /**
     * Constructor.
     *
     * @param TraceableEventDispatcher  $dispatcher
     * @param integer $minLength
     * @param integer$maxEntries
     */
    public function __construct(TraceableEventDispatcher $dispatcher, $minLength, $maxEntries)
    {
        $this->dispatcher = $dispatcher;
        $this->minLength = $minLength;
        $this->maxEntries = $maxEntries;
    }

    /**
     * {@inheritdoc}
     *
     * @param SearcherInterface searcher
     */
    public function addSearcher(SearcherInterface $searcher)
    {
        $this->searchers[] = $searcher;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $term
     * @param array $options
     * @return \Purjus\SearchBundle\Entity\Group[]
     */
    public function search($term, array $options = array())
    {

        $event = new SearchEvent($term, $options);
        $this->dispatcher->dispatch(SearchEvent::SEARCH_BEGIN, $event);

        $results = $this->doSearch($term, $options);

        $event->setResults($results); // set result in the event, so we can interact
        $this->dispatcher->dispatch(SearchEvent::SEARCH_END, $event);

        $this->results = $results;

        return $results;

    }

    /**
     * Check & call all the searchers.
     *
     * @param string $term
     * @param array $options
     * @return \Purjus\SearchBundle\Entity\Group[]
     */
    protected function doSearch($term, array $options = array())
    {

        $results = array();
        $domains = $options['domains'];

        foreach ($this->searchers as $searcher) {

            // if domains is not specified or the current searcher domain is in the searchables domains
            if (empty($domains) || in_array($searcher->getDomain(), $domains)) {

                $results[] = $searcher->search($term, array_merge(
                    array('max_entries' => $this->maxEntries,),
                    $options,
                ));

            }

        }

        return $results;
    }

}
