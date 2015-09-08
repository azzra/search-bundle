<?php
namespace Purjus\SearchBundle\Searcher;

use Purjus\SearchBundle\Convention\SearcherInterface;
use Symfony\Component\Routing\Router;

/**
 *
 * @author m4rc3l
 *
 */
class DemoSearcher implements SearcherInterface
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
    public function search($term)
    {

        $routes = $this->router->getRouteCollection()->all();

        $results = array();
        foreach ($routes as $name => $route) {
            if (stripos($name, $term) !== false) {
                $results[] = $name;
            }
        }

        return array(
            'type' => array(
                'name' => 'ma_cat',
                'desc' => 'yeayay'
            ),
            'results' => $results
        );

    }
}
