<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Model\SearcherManagerInterface;

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
     * @var integer Minimum length of a search term
     */
    protected $minLength;

    /**
     * @var integer Maximum entries
     */
    protected $maxEntries;

    /**
     * @var Searchers[] Searchers
     */
    protected $searchers = array();

    /**
     * @var Search[] Search results
     */
    protected $results = array();


    /**
     * Constructor.
     *
     * @param integer $minLength
     * @param integer$maxEntries
     */
    public function __construct($minLength, $maxEntries)
    {
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
     * @return Group[]
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
