<?php

namespace Purjus\SearchBundle\Manager;

use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Model\SearcherManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Search manager. Will call all the searcher.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SearchManager implements SearcherManagerInterface
{

    /**
     * @var RequestStack $requestStack
     */
    protected $requestStack;

    /**
     * @var integer Minimum length of a search term
     */
    protected $minLength;

    /**
     * @var integer Maximum entries
     */
    protected $maxEntries;

    /**
     * @var Searchers[] Searchers
     */
    protected $searchers = array();

    /**
     * @var Search[] Search results
     */
    protected $results = array();


    public function __construct(RequestStack $requestStack, $minLength, $maxEntries)
    {
        $this->requestStack = $requestStack;
        $this->minLength = $minLength;
        $this->maxEntries = $maxEntries;
    }

    /**
     * {@inheritdoc}
     */
    public function addSearcher(SearcherInterface $searcher)
    {
        $this->searchers[] = $searcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults($term, array $options = array())
    {

        if (strlen($term) < $this->minLength) {
            return array();
        }

        $results = array();

        foreach ($this->searchers as $searcher) {
            $results[] = $searcher->search($term, array(
                'max_entries' => $this->maxEntries,
                'locale' => $this->requestStack->getCurrentRequest()->getLocale()
            ));
        }

        $this->results = $results;

        return $results;

    }
}
