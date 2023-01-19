<?php

namespace Webnuvola\Laravel\Active\Tests;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Orchestra\Testbench\TestCase;

final class ActiveTest extends TestCase
{
    public function testActiveClassFunction(): void
    {
        $this->assertEquals('active', active_class(true));
        $this->assertEquals('', active_class(false));

        $this->assertEquals('current', active_class(true, 'current'));
        $this->assertEquals('', active_class(false, 'current'));

        $this->assertEquals('active-class', active_class(true, 'active-class', 'inactive-class'));
        $this->assertEquals('inactive-class', active_class(false, 'active-class', 'inactive-class'));

        $this->assertEquals('active', active_class(new Request()));
        $this->assertEquals('', active_class(null));

        $this->assertEquals('active', active_class(['foo']));
        $this->assertEquals('', active_class([]));

        $this->assertEquals('active', active_class(1));
        $this->assertEquals('', active_class(0));
    }

    public function testIfUriFunction(): void
    {
        $this->app->instance('request', Request::create('/test-uri'));

        $this->assertTrue(if_uri('test-uri'));
        $this->assertFalse(if_uri('another-uri'));

        $this->assertTrue(if_uri(['another-uri', 'test-uri']));
        $this->assertFalse(if_uri(['another-uri', 'test']));

        $this->assertTrue(if_uri('another-uri', 'test-uri'));
        $this->assertFalse(if_uri('another-uri', 'test'));
    }

    public function testIfUriPatternFunction(): void
    {
        $this->app->instance('request', Request::create('/test-uri-pattern'));

        $this->assertTrue(if_uri_pattern('test-uri-pattern'));
        $this->assertFalse(if_uri_pattern('another-uri-pattern'));

        $this->assertTrue(if_uri_pattern('test-uri*'));
        $this->assertFalse(if_uri_pattern('another-uri*'));

        $this->assertTrue(if_uri_pattern(['another-uri-pattern', 'test-uri-pattern']));
        $this->assertFalse(if_uri_pattern(['another-uri-pattern', 'test-uri']));

        $this->assertTrue(if_uri_pattern(['another-uri*', 'test-uri*']));
        $this->assertFalse(if_uri_pattern(['another-uri*', 'test-pattern*']));

        $this->assertTrue(if_uri_pattern('another-uri-pattern', 'test-uri-pattern'));
        $this->assertFalse(if_uri_pattern('another-uri-pattern', 'test-uri'));

        $this->assertTrue(if_uri_pattern('another-uri*', 'test-uri*'));
        $this->assertFalse(if_uri_pattern('another-uri*', 'test-pattern*'));
    }

    public function testIfRouteFunction(): void
    {
        $request = Request::create('/test-route');
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/test-route', ['as' => 'test.route']);
            $route->bind($request);

            return $route;
        });

        $this->app->instance('request', $request);

        $this->assertTrue(if_route('test.route'));
        $this->assertFalse(if_route('another.route'));

        $this->assertTrue(if_route(['another.route', 'test.route']));
        $this->assertFalse(if_route(['another.route', 'test']));

        $this->assertTrue(if_route('another.route', 'test.route'));
        $this->assertFalse(if_route('another.route', 'test'));
    }

    public function testIfRoutePatternFunction(): void
    {
        $request = Request::create('/test-route-pattern');
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/test-route-pattern', ['as' => 'test.route.pattern']);
            $route->bind($request);

            return $route;
        });

        $this->app->instance('request', $request);

        $this->assertTrue(if_route_pattern('test.route.pattern'));
        $this->assertFalse(if_route_pattern('another.route.pattern'));

        $this->assertTrue(if_route_pattern('test.route*'));
        $this->assertFalse(if_route_pattern('another.route*'));

        $this->assertTrue(if_route_pattern(['another.route.pattern', 'test.route.pattern']));
        $this->assertFalse(if_route_pattern(['another.route.pattern', 'test.route']));

        $this->assertTrue(if_route_pattern(['another.route*', 'test.route*']));
        $this->assertFalse(if_route_pattern(['another.route*', 'test.pattern*']));

        $this->assertTrue(if_route_pattern('another.route.pattern', 'test.route.pattern'));
        $this->assertFalse(if_route_pattern('another.route.pattern', 'test.route'));

        $this->assertTrue(if_route_pattern('another.route*', 'test.route*'));
        $this->assertFalse(if_route_pattern('another.route*', 'test.pattern*'));
    }

    public function testIfRouteParamFunction(): void
    {
        $request = Request::create('/test-route-param');
        $request->setRouteResolver(function () use ($request) {
            $route = new Route('GET', '/test-route-param', ['as' => 'test.route.param']);
            $route->bind($request);
            $route->setParameter('foo', 'bar');

            return $route;
        });

        $this->app->instance('request', $request);

        $this->assertTrue(if_route_param('foo', 'bar'));
        $this->assertFalse(if_route_param('foo', 'baz'));
    }
}
