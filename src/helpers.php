<?php

if (! function_exists('active_class')) {
    /**
     * Get the active class if the condition is not false.
     */
    function active_class(mixed $condition, string $activeClass = 'active', string $inactiveClass = ''): string
    {
        return $condition ? $activeClass : $inactiveClass;
    }
}

if (! function_exists('if_uri')) {
    /**
     * Determine if the current request URI matches a pattern.
     */
    function if_uri(mixed ...$patterns): bool
    {
        return request()->is(...$patterns);
    }
}

if (! function_exists('if_uri_pattern')) {
    /**
     * Determine if the current request URI matches a pattern.
     *
     * @see if_uri()
     */
    function if_uri_pattern(mixed ...$patterns): bool
    {
        return request()->is(...$patterns);
    }
}

if (! function_exists('if_route')) {
    /**
     * Determine if the route name matches a given pattern.
     */
    function if_route(mixed ...$patterns): bool
    {
        return request()->routeIs(...$patterns);
    }
}

if (! function_exists('if_route_pattern')) {
    /**
     * Determine if the route name matches a given pattern.
     *
     * @see if_route()
     */
    function if_route_pattern(mixed ...$patterns): bool
    {
        return request()->routeIs(...$patterns);
    }
}

if (! function_exists('if_route_param')) {
    /**
     * Check if the parameter of the current route has the correct value.
     */
    function if_route_param(string $param, mixed $value): bool
    {
        return request()->route($param) === $value;
    }
}
