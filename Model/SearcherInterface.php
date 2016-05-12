<?php

namespace Purjus\SearchBundle\Model;

/**
 * Searcher interface.
 *
 * @author Purjus Communication
 * @author Tom
 */
interface SearcherInterface
{
    /**
     * Return the results of a "part" os the whole search.
     *
     * @param string $term
     * @param array  $options
     *
     * @return Group
     */
    public function search($term, array $options = []);
}
