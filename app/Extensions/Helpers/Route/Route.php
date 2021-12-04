<?php

namespace App\Extensions\Helpers\Route;

use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Str;

/**
 * @method static \Illuminate\Routing\Route delete(array|string|callable|string $primary, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route get(array|string|callable|string $primary, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route patch(array|string|callable|string $primary, array|string|callable|null $action = null)
 * @method static \Illuminate\Routing\Route post(array|string|callable|string $primary, array|string|callable|null $action = null)
 */

class Route extends FacadesRoute
{
    public static function namedPrefix(string $prefix)
    {
        return static::prefix($prefix)->name($prefix . '.');
    }

    public static function __callStatic($method, $args)
    {
        if (is_array($args[0])) $args = ['', ...$args];

        if (in_array($method, ['delete', 'get', 'patch', 'post']))
        {
            $name = '';

            if (isset($args[1][1]) && is_string($args[1][1]) && strlen($args[1][1]) <= 10)
            {
                if (!empty($args[0]) && !Str::contains($args[0], ['{', '}']) && $args[0] != $args[1][1])
                {
                    $name .= $args[0] . '.';
                }

                $name .= $args[1][1];
            }

            elseif (!empty($args[0]) && !Str::contains($args[0], ['{', '}']))
            {
                $name .= $args[0];
            }

            return parent::__callStatic($method, $args)->name($name);
        }

        return parent::__callStatic($method, $args);
    }
}
