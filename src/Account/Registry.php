<?php
namespace FinanceGeni\Interview\Account;

/**
 * registry class
 */
class Registry
{
    /**
     * storage
     */
    public static $storage = array();

    /**
     * gets the value of a variable
     *
     * @param string $namespace
     * @param string $key variable name
     * @todo create multiple level namespaces array
     *
     * @return mixed
     */
    public static function get($namespace, $key)
    {
        return isset(self::$storage[$namespace . ':' . $key]) ? self::$storage[$namespace . ':' . $key] : null;
    }

    /**
     * sets the value of a variable
     *
     * @param string $namespace
     * @param string $key variable name
     * @param mixed  $value
     */
    public static function set($namespace, $key, $value)
    {
        self::$storage[$namespace . ':' . $key] = $value;
    }

    /**
     * deletes variable from registry
     *
     * @param string $namespace
     * @param string $key variable name
     *
     * @return mixed
     */
    public static function del($namespace, $key)
    {
        if (isset(self::$storage[$namespace . ':' . $key]))
            unset(self::$storage[$namespace . ':' . $key]);
    }
}