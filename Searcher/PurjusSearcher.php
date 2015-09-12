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
     * @var string $domain
     */
    protected $domain;

    /**
     * @var array options
     */
    protected $options = array();

    /**
     * @var integer number of items
     */
    protected $counter = 0;

    /**
     * Constructor
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
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }


}
