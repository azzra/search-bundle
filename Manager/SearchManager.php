<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Convention\SearcherInterface;
/**
 * Event manager
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchManager
{

    /**
     * @var string The needle
     */
    protected $term;

    /**
     * @var integer Minimum length of a search term.
     */
    protected $minLength;

    /**
     * @var array Searchers
     */
    protected $searchers = array();

    /**
     * @var array Search results
     */
    protected $results = array();


    public function __construct()
    {
//         $this->minLength = $minLength;
    }

    /**
     * Add a searcher
     *
     * @param SearcherInterface $searcher
     */
    public function addSearcher(SearcherInterface $searcher)
    {
        $this->searchers[] = $searcher;
    }

    /**
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }

    /**
     * Call all the searchers for the search method
     *
     * @return array
     */
    public function getResults()
    {

        $results = array();

        foreach ($this->searchers as $searcher) {
            $results[] = $searcher->search($this->term);
        }

        $this->results = $results;

        return $results;

    }
}
