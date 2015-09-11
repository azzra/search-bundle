<?php
namespace Purjus\SearchBundle\Searcher;

use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Entity\Group;
use Purjus\SearchBundle\Entity\Entry;

/**
 * Base class for a Searcher.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
abstract class PurjusSearcher implements SearcherInterface
{

    /**
     * @var array options
     */
    protected $options = array();

    /**
     * @var integer number of items
     */
    protected $counter = 0;


    /**
     * Add an $entry to a $group until $this->options['max_entries'] is reached.
     *
     * @param Group $group
     * @param Entry $entry
     * @return boolean
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
     * Get options
     *
     * @return the array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options
     *
     * @param array $options
     * @return PurjusSearcher
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }


}
