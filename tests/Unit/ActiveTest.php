<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

test('active_class function', function () {
    expect(active_class(true))->toBe('active')
        ->and(active_class(false))->toBe('')

        ->and(active_class(true, 'current'))->toBe('current')
        ->and(active_class(false, 'current'))->toBe('')

        ->and(active_class(true, 'active-class', 'inactive-class'))->toBe('active-class')
        ->and(active_class(false, 'active-class', 'inactive-class'))->toBe('inactive-class');
});

test('if_uri function', function () {
    $this->app->instance('request', Request::create('/test-uri'));

    expect(if_uri('test-uri'))->toBeTrue()
        ->and(if_uri('another-uri'))->toBeFalse()

        ->and(if_uri(['another-uri', 'test-uri']))->toBeTrue()
        ->and(if_uri(['another-uri', 'test']))->toBeFalse()

        ->and(if_uri('another-uri', 'test-uri'))->toBeTrue()
        ->and(if_uri('another-uri', 'test'))->toBeFalse();
});

test('if_uri_pattern function', function () {
    $this->app->instance('request', Request::create('/test-uri-pattern'));

    expect(if_uri_pattern('test-uri-pattern'))->toBeTrue()
        ->and(if_uri_pattern('another-uri-pattern'))->toBeFalse()

        ->and(if_uri_pattern('test-uri*'))->toBeTrue()
        ->and(if_uri_pattern('another-uri*'))->toBeFalse()

        ->and(if_uri_pattern(['another-uri-pattern', 'test-uri-pattern']))->toBeTrue()
        ->and(if_uri_pattern(['another-uri-pattern', 'test-uri']))->toBeFalse()

        ->and(if_uri_pattern(['another-uri*', 'test-uri*']))->toBeTrue()
        ->and(if_uri_pattern(['another-uri*', 'test-pattern*']))->toBeFalse()

        ->and(if_uri_pattern('another-uri-pattern', 'test-uri-pattern'))->toBeTrue()
        ->and(if_uri_pattern('another-uri-pattern', 'test-uri'))->toBeFalse()

        ->and(if_uri_pattern('another-uri*', 'test-uri*'))->toBeTrue()
        ->and(if_uri_pattern('another-uri*', 'test-pattern*'))->toBeFalse();
});

test('if_route function', function () {
    $request = Request::create('/test-route');

    $request->setRouteResolver(static function () use ($request): Route {
        $route = new Route('GET', '/test-route', ['as' => 'test.route']);
        $route->bind($request);

        return $route;
    });

    $this->app->instance('request', $request);

    expect(if_route('test.route'))->toBeTrue()
        ->and(if_route('another.route'))->toBeFalse()

        ->and(if_route(['another.route', 'test.route']))->toBeTrue()
        ->and(if_route(['another.route', 'test']))->toBeFalse()

        ->and(if_route('another.route', 'test.route'))->toBeTrue()
        ->and(if_route('another.route', 'test'))->toBeFalse();
});

test('if_route_pattern function', function () {
    $request = Request::create('/test-route-pattern');

    $request->setRouteResolver(static function () use ($request): Route {
        $route = new Route('GET', '/test-route-pattern', ['as' => 'test.route.pattern']);
        $route->bind($request);

        return $route;
    });

    $this->app->instance('request', $request);

    expect(if_route_pattern('test.route.pattern'))->toBeTrue()
        ->and(if_route_pattern('another.route.pattern'))->toBeFalse()

        ->and(if_route_pattern('test.route*'))->toBeTrue()
        ->and(if_route_pattern('another.route*'))->toBeFalse()

        ->and(if_route_pattern(['another.route.pattern', 'test.route.pattern']))->toBeTrue()
        ->and(if_route_pattern(['another.route.pattern', 'test.route']))->toBeFalse()

        ->and(if_route_pattern(['another.route*', 'test.route*']))->toBeTrue()
        ->and(if_route_pattern(['another.route*', 'test.pattern*']))->toBeFalse()

        ->and(if_route_pattern('another.route.pattern', 'test.route.pattern'))->toBeTrue()
        ->and(if_route_pattern('another.route.pattern', 'test.route'))->toBeFalse()

        ->and(if_route_pattern('another.route*', 'test.route*'))->toBeTrue()
        ->and(if_route_pattern('another.route*', 'test.pattern*'))->toBeFalse();
});

test('if_route_param function', function () {
    $request = Request::create('/test-route-param');

    $request->setRouteResolver(static function () use ($request): Route {
        $route = new Route('GET', '/test-route-param', ['as' => 'test.route.param']);
        $route->bind($request);
        $route->setParameter('foo', 'bar');

        return $route;
    });

    $this->app->instance('request', $request);

    expect(if_route_param('foo', 'bar'))->toBeTrue()
        ->and(if_route_param('foo', 'baz'))->toBeFalse();
});
