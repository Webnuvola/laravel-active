<?php

if (! function_exists('active_class')) {
    /**
     * Get the active class if the condition is not false.
     *
     * @param  mixed $condition
     * @param  string $activeClass
     * @param  string $inactiveClass
     * @return string
     */
    function active_class($condition, string $activeClass = 'active', string $inactiveClass = ''): string
    {
        return $condition ? $activeClass : $inactiveClass;
    }
}

if (! function_exists('if_uri')) {
    /**
     * Determine if the current request URI matches a pattern.
     *
     * @param  mixed ...$patterns
     * @return bool
     */
    function if_uri(...$patterns): bool
    {
        return request()->is(...$patterns);
    }
}

if (! function_exists('if_uri_pattern')) {
    /**
     * Determine if the current request URI matches a pattern.
     *
     * @see if_uri()
     *
     * @param  mixed ...$patterns
     * @return bool
     */
    function if_uri_pattern(...$patterns): bool
    {
        return request()->is(...$patterns);
    }
}

if (! function_exists('if_route')) {
    /**
     * Determine if the route name matches a given pattern.
     *
     * @param  mixed ...$patterns
     * @return bool
     */
    function if_route(...$patterns): bool
    {
        return request()->routeIs(...$patterns);
    }
}

if (! function_exists('if_route_pattern')) {
    /**
     * Determine if the route name matches a given pattern.
     *
     * @see if_route()
     *
     * @param  mixed ...$patterns
     * @return bool
     */
    function if_route_pattern(...$patterns): bool
    {
        return request()->routeIs(...$patterns);
    }
}

if (! function_exists('if_route_param')) {
    /**
     * Check if the parameter of the current route has the correct value.
     *
     * @param  string $param
     * @param  mixed $value
     * @return bool
     */
    function if_route_param(string $param, $value): bool
    {
        return request()->route($param) === $value;
    }
}
