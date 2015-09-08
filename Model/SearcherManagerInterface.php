<?php

namespace Purjus\SearchBundle\Model;

interface SearcherManagerInterface
{

    /**
     * Add a searcher
     *
     * @param SearcherInterface $searcher
     */
    public function addSearcher(SearcherInterface $searcher);

    /**
     * Call all the searchers for the search method
     *
     * @param string $term
     * @return array
     */
    public function getResults($term, array $options = array());

}
