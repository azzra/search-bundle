<?php

namespace Purjus\SearchBundle\Model;

interface SearcherInterface
{

    /**
     * Return the results of a "part" os the whole search.
     *
     * @return array
     */
    public function search($term, array $options = array());

}
