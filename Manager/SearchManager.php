<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Model\SearcherManagerInterface;

/**
 * Event manager
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchManager implements SearcherManagerInterface
{

    /**
     * @var integer Minimum length of a search term.
     */
    protected $minLength;

    /**
     * @var integer Maximum entries
     */
    protected $maxEntries;

    /**
     * @var array Searchers
     */
    protected $searchers = array();

    /**
     * @var array Search results
     */
    protected $results = array();


    public function __construct($minLength, $maxEntries)
    {
        $this->minLength = $minLength;
        $this->maxEntries = $maxEntries;
    }

    /**
     * {@inheritdoc}
     */
    public function addSearcher(SearcherInterface $searcher)
    {
        $this->searchers[] = $searcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults($term, array $options = array())
    {

        if (strlen($term) < $this->minLength) {
            return array();
        }

        $results = array();

        foreach ($this->searchers as $searcher) {
            $results[] = $searcher->search($term, array(
                'max_entries' => $this->maxEntries,
            ));
        }

        $this->results = $results;

        return $results;

    }
}
