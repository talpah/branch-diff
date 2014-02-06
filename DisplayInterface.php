<?php

/**
 * Created by PhpStorm.
 * User: cosmin
 * Date: 2/6/14
 * Time: 10:39 AM
 */
interface DisplayInterface {

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setReturn($status);

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function bold($text);

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function italic($text);

    /**
     * @param string $text
     * @param string $color
     * @param string $bgcolor
     *
     * @return DisplayInterface
     */
    public function color($text, $color, $bgcolor=null);

    /**
     * @param string $text
     * @param int    $level
     *
     * @return DisplayInterface
     */
    public function idented($text, $level=1);

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function inline($text);

    /**
     * @return DisplayInterface
     */
    public function newline();

}