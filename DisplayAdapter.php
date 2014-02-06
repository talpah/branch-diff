<?php

/**
 * Created by PhpStorm.
 * User: cosmin
 * Date: 2/6/14
 * Time: 11:09 AM
 */
class DisplayAdapter {

    protected static $ADAPTERS=array(
        'console'=>'DisplayConsole',
        'browser'=>'DisplayBrowser'
    );

    /**
     * @param $type
     *
     * @return DisplayInterface
     * @throws Exception
     */
    public static function create($type) {
        if (!isset(self::$ADAPTERS[$type])) {
            throw new \Exception('Adapter ' . $type . ' doesn\'t exist.');
        }
        require_once(self::$ADAPTERS[$type] . ".php");
        return new self::$ADAPTERS[$type];
    }
}