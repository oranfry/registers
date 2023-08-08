<?php

namespace Registers;

final class Register
{
    private static array $implementations = [];
    private static array $libraries = [];

    private function __construct() {}

    public static function available(string $type, ?string $name = null): array
    {
        if (!array_key_exists($type, self::$implementations)) {
            throw new Exception("Type [$type] has not been registered");
        }

        if ($name !== null) {
            return array_key_exists($name, self::$implementations[$type]) ? [$name] : [];
        }

        return array_keys(self::$implementations[$type]);
    }

    private static function create(string $type, string $name): object
    {
        if (!array_key_exists($type, self::$implementations)) {
            throw new Exception("Type [$type] has not been registered");
        }

        if (!$class = self::$implementations[$type][$name] ?? null) {
            throw new Exception("Could not find a [$type] implementation for [$name]");
        }

        return new $class;
    }

    public static function deregister(string $type, ?string $name = null): void
    {
        if ($name) {
            unset(self::$implementations[$type][$name]);
            unset(self::$libraries[$type][$name]);
        } else {
            unset(self::$implementations[$type]);
            unset(self::$libraries[$type]);
        }
    }

    public static function load(string $type, string $name): object
    {
        return self::$libraries[$type][$name] ??= self::create($type, $name);
    }

    public static function register(string $type, array $implementations): void
    {
        if (array_key_exists($type, self::$implementations)) {
            throw new Exception("Type [$type] has already been registered");
        }

        foreach ($implementations as $name => $class) {
            if (!is_string($class)) {
                throw new Exception("Implementation array value should be the classname as string");
            }
        }

        self::$implementations[$type] = $implementations;
    }
}
