<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 07/06/17
 * Time: 14:55
 */

namespace Wollanup\Api\Swagger\Test;

use Eukles\Container\Container;
use Eukles\Container\ContainerInterface;
use Eukles\RouteMap\RouteMapAbstract;
use Eukles\RouteMap\RouteMapInterface;
use Eukles\Service\Router\RouteInterface;
use Eukles\Service\Router\Router;
use PHPUnit\Framework\TestCase;
use Wollanup\Api\Swagger\Definitions;
use Wollanup\Api\Swagger\Operation;

class DefinitionsTest extends TestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Operation
     */
    protected $operation;
    /**
     * @var RouteInterface
     */
    protected $route;
    /**
     * @var RouteMapInterface
     */
    protected $routeMap;
//    public function mock($pattern, $method)
//    {
////        $this->route     = $this->routeMap->get($pattern)
////            ->setPackage('foo')
////            ->setActionClass(FooAction::class)
////            ->setActionMethod($method);
////        $parser          = new Std();
////        $routesPattern   = $parser->parse($this->route->getPattern());
//        $this->operation = new Operation($this->route, $routesPattern[0], new Definitions($this->container));
//
//        return $this->operation;
//    }
//
    public function setUp()
    {
        parent::setUp();
        $this->container = new Container();

        /** @var RouteMapInterface $routeMap */
        $this->routeMap = $this->getMockForAbstractClass(RouteMapAbstract::class, [$this->container]);
    }

    public function testBuild()
    {
        $definitions = new Definitions($this->container);
        $router      = new Router(null, $this->container, new RoutesClasses($this->container), false);

        $route = $this->routeMap->get("/")
            ->setPackage('foo')
            ->setActionClass(FooAction::class)
            ->setActionMethod("test");

        $router->addResourceRoute($route);
        $definitions->buildAll($router);
        $this->assertTrue(true);
    }

    public function testBuildExtra()
    {
        $definitions = new Definitions($this->container);
        $definitions->buildExtra();
        $this->assertSame(
            '{"Propel\/Runtime\/Util\/PropelModelPager":{"type":"object","properties":{"haveToPaginate":{"type":"boolean"},"page":{"type":"integer","default":1},"firstPage":{"type":"integer","default":1},"lastPage":{"type":"integer","default":1},"total":{"type":"integer","default":1},"first":{"type":"integer","default":1},"last":{"type":"integer","default":1},"limit":{"type":"integer","default":20}}}}',
            json_encode($definitions));
    }
}
