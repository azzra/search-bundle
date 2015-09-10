<?php

namespace Purjus\SearchBundle\Model;

/**
 * Searcher Manager interface.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
interface SearcherManagerInterface
{

    /**
     * Add a searcher.
     *
     * @param SearcherInterface $searcher
     */
    public function addSearcher(SearcherInterface $searcher);

    /**
     * Call all the searchers for the search method.
     *
     * @param string $term
     * @param array $options
     * @return Group[]
     */
    public function getResults($term, array $options = array());

}
