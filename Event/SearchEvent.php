<?php

namespace Purjus\SearchBundle\Event;

use Purjus\SymfonyBundle\Event\PurjusEvent;

/**
 * Search event.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchEvent extends PurjusEvent
{

    /**
     * @var string Start of a search
     */
    const SEARCH_BEGIN = 'purjus_search.begin';

    /**
     * @var string Search end
     */
    const SEARCH_END = 'purjus_search.end';

    /**
     * @var string Search term
     */
    protected $term;

    /**
     * @var array Search configuration
     */
    protected $config;

    /**
     * @var array The results
     */
    protected $results = array();

    /**
     * Constructor
     *
     * @param string $term
     * @param array $config
     */
    public function __construct($term)
    {
        $this->term = $term;
    }

    /**
     * Get term
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get results
     *
     * @return the array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * So we can changes the results is needed
     *
     * @param array $results
     * @return SearchEvent
     */
    public function setResults(array $results)
    {
        $this->results = $results;
        return $this;
    }


}
