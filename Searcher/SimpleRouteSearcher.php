<?php
namespace Purjus\SearchBundle\Searcher;

use Purjus\SearchBundle\Model\SearcherInterface;
use Symfony\Component\Routing\Router;
use Purjus\SearchBundle\Entity\Group;
use Purjus\SearchBundle\Entity\Entry;

/**
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

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
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
