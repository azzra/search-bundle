<?php
namespace Purjus\SearchBundle\Searcher;

use Symfony\Component\Routing\Router;
use Purjus\SearchBundle\Entity\Group;
use Purjus\SearchBundle\Entity\Entry;

/**
 * Demo searcher, looks in all the route and perform
 * a simple text search in the name.
 *
 * @author Purjus Communication
 * @author Tom
 *
 */
class SimpleRouteSearcher extends PurjusSearcher
{

    /**
     * @var Router Router
     */
    protected $router;

    /**
     * Constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }


    /**
     * {@inheritdoc}
     *
     * @see \Purjus\SearchBundle\Model\SearcherInterface::search()
     * @param string $term
     * @param array $options
     * @return Group
     */
    public function search($term, array $options = array())
    {

        $this->options = $options;
        $group = new Group('Routes', $this->router->generate('homepage'));

        $routes = $this->router->getRouteCollection()->all();

        foreach ($routes as $name => $route) {

            if (stripos($name, $term) !== false) {

                $entry = new Entry($name, $this->router->generate('homepage'));

                if (!$this->addToMax($group, $entry)) {
                    break;
                }

            }

        }

        return $group;

    }
}
