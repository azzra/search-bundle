<?php

namespace Purjus\SearchBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Search event
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchEvent extends Event
{

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
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
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
     */
    public function setResults(array $results)
    {
        $this->results = $results;
        return $this;
    }


}
