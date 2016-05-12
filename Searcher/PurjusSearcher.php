<?php

namespace Purjus\SearchBundle\Searcher;

use Purjus\SearchBundle\Entity\Entry;
use Purjus\SearchBundle\Entity\Group;
use Purjus\SearchBundle\Model\SearcherInterface;

/**
 * Base class for a Searcher.
 *
 * @author Purjus Communication
 * @author Tom
 */
abstract class PurjusSearcher implements SearcherInterface
{
    /**
     * @var string
     */
    protected $domain;

    /**
     * @var array options
     */
    protected $options = [];

    /**
     * @var int number of items
     */
    protected $counter = 0;

    /**
     * Constructor.
     *
     * @param string $domain
     */
    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Add an $entry to a $group until $this->options['max_entries'] is reached.
     *
     * @param Group $group
     * @param Entry $entry
     *
     * @return bool
     */
    protected function addToMax(Group $group, Entry $entry)
    {
        if ($this->counter >= $this->options['max_entries']) {
            return false;
        }

        $group->addEntry($entry);
        $this->counter++;

        return true;
    }

    /**
     * Get domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
