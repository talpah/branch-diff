<?php
require_once('DisplayInterface.php');

/**
 * Created by PhpStorm.
 * User: cosmin
 * Date: 2/6/14
 * Time: 10:35 AM
 */
class DisplayConsole implements DisplayInterface {

    protected $return=false;

    protected static $ANSI_CODES=array(
        "off"      =>0,
        "bold"     =>1,
        "italic"   =>3,
        "underline"=>4,
        "blink"    =>5,
        "inverse"  =>7,
        "hidden"   =>8,
    );

    protected static $ANSI_COLORS=array(
        "black"  =>30,
        "red"    =>31,
        "green"  =>32,
        "yellow" =>33,
        "blue"   =>34,
        "magenta"=>35,
        "cyan"   =>36,
        "white"  =>37,
    );
    protected static $ANSI_BG_COLORS=array(
        "black"  =>40,
        "red"    =>41,
        "green"  =>42,
        "yellow" =>43,
        "blue"   =>44,
        "magenta"=>45,
        "cyan"   =>46,
        "white"  =>47
    );

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function bold($text) {
        $output="\033[" . self::$ANSI_CODES['bold'] . "m$text\033[" . self::$ANSI_CODES["off"] . "m";
        if ($this->return) {
            return $output;
        } else {
            echo $output;
            return $this;
        }
    }

    /**
     * @param string $text
     * @param int    $level
     *
     * @return DisplayInterface
     */
    public function idented($text, $level=1) {
        $margin=str_repeat("\t", $level);
        $output="{$margin}{$text}";
        if ($this->return) {
            return $output;
        } else {
            echo $output;
            return $this;
        }
    }

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function inline($text) {
        if ($this->return) {
            return $text;
        } else {
            echo $text;
            return $this;
        }
    }

    /**
     * @return DisplayInterface
     */
    public function newline() {
        if ($this->return) {
            return "\n";
        } else {
            echo "\n";
            return $this;
        }
    }

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function italic($text) {
        $output="\033[" . self::$ANSI_CODES['italic'] . "m$text\033[" . self::$ANSI_CODES["off"] . "m";
        if ($this->return) {
            return $output;
        } else {
            echo $output;
            return $this;
        }
    }

    /**
     * @param string $text
     * @param string $color
     * @param string $bgcolor
     *
     * @return DisplayInterface
     */
    public function color($text, $color, $bgcolor=null) {
        $fg=isset(self::$ANSI_COLORS[$color]) ? "\033[" . self::$ANSI_COLORS[$color] . "m" : '';
        $bg=$bgcolor && isset(self::$ANSI_BG_COLORS[$bgcolor]) ? "\033[" . self::$ANSI_BG_COLORS[$bgcolor] . "m" : '';
        $output="{$bg}{$fg}$text\033[" . self::$ANSI_CODES["off"] . "m";
        if ($this->return) {
            return $output;
        } else {
            echo $output;
            return $this;
        }
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function setReturn($status) {
        $this->return=$status;
        return $this;
    }

    public function __toString() {
        return '';
    }
}