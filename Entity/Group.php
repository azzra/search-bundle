<?php

namespace Purjus\SearchBundle\Entity;

/**
 * A group of results.
 *
 * @author Purjus Communication
 * @author Tom
 */
class Group extends Entry
{
    /**
     * @var Entry[] entries
     */
    protected $entries = [];

    /**
     * Get entries.
     *
     * @return the array
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Add an entriy.
     *
     * @param Entry $entries
     */
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Set entries.
     *
     * @param array $entries
     */
    public function setEntries(array $entries)
    {
        $this->entries = $entries;

        return $this;
    }
}
