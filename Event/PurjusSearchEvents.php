<?php

namespace Purjus\SearchBundle\Event;

/**
 * Search events.
 *
 * @author Purjus Communication
 * @author Tom
 */
final class PurjusSearchEvents
{
    /**
     * @var string Start of a search
     */
    const SEARCH_BEGIN = 'purjus_search.begin';

    /**
     * @var string Search end
     */
    const SEARCH_END = 'purjus_search.end';
}
