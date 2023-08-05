<?php

namespace Registers;

use Exception;

abstract class Register
{
    protected static array $library = [];

    public static final function available(): array
    {
        return array_keys(static::$implementations);
    }

    private static function create(string $name): object
    {
        if (!$class = static::$implementations[$name] ?? null) {
            throw new Exception('Could not find an implementation for [' . get_called_class() . "]:[$name]");
        }

        return new $class;
    }

    public static final function load(string $name): object
    {
        return self::$library[get_called_class()][$name] ??= self::create($name);
    }
}
