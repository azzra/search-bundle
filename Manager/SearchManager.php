<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Event\SearchEvent;
use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Model\SearcherManagerInterface;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Search manager. Will call all the searcher.
 *
 * @author Purjus Communication
 * @author Tom
 */
class SearchManager implements SearcherManagerInterface
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var int Minimum length of a search term
     */
    protected $minLength;

    /**
     * @var int Maximum entries
     */
    protected $maxEntries;

    /**
     * @var \Purjus\SearchBundle\Model\SearcherInterface[] Searchers
     */
    protected $searchers = [];

    /**
     * @var \Purjus\SearchBundle\Entity\Group[] Search results
     */
    protected $results = [];

    /**
     * @var string used by the search block
     */
    protected $term;

    /**
     * Constructor.
     *
     * @param TraceableEventDispatcher $dispatcher
     * @param int                      $minLength
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
     * @param array  $options
     *
     * @return \Purjus\SearchBundle\Entity\Group[]
     */
    public function search($term, array $options = [])
    {
        $event = new SearchEvent($term, $options);
        $this->dispatcher->dispatch(SearchEvent::SEARCH_BEGIN, $event);

        $this->term = $term;
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
     * @param array  $options
     *
     * @return \Purjus\SearchBundle\Entity\Group[]
     */
    protected function doSearch($term, array $options = [])
    {
        $results = [];
        $domains = $options['domains'];

        foreach ($this->searchers as $searcher) {

            // if domains is not specified or the current searcher domain is in the searchables domains
            if (empty($domains) || in_array($searcher->getDomain(), $domains)) {
                $results[] = $searcher->search($term, array_merge(
                    ['max_entries' => $this->maxEntries],
                    $options
                ));
            }
        }

        return $results;
    }

    /**
     * Get term.
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }
}
