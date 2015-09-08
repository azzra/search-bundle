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
class SimpleRouteSearcher implements SearcherInterface
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

        $routes = $this->router->getRouteCollection()->all();

        $group = new Group('Routes', $this->router->generate('homepage'));

        $counter = 0;
        foreach ($routes as $name => $route) {

            if (stripos($name, $term) !== false) {
                $entity = new Entry($name, "http://");
                $group->addEntry($entity);
                $counter++;
            }

            if ($counter >= $options['max_entries']) {
                break;
            }

        }

        return $group;

    }
}
