<?php
require_once('DisplayInterface.php');

/**
 * Created by PhpStorm.
 * User: cosmin
 * Date: 2/6/14
 * Time: 10:37 AM
 */
class DisplayBrowser implements DisplayInterface {

    protected $return=false;

    public function __construct() {
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<title>BranchDiff</title>";
        echo "</head>";
        echo "<body style=\"background-color: black; color: white; font-family: sans-serif;\">";
        echo "<h1>";
        $this->color("-- Branch", 'red');
        $this->color("Diff ++", 'green');
        echo "</h1>";
    }

    /**
     * @param string $text
     *
     * @return DisplayInterface
     */
    public function bold($text) {
        $output="<strong>$text</strong>";
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
        $margin=20;
        $margin*=$level;
        $output="<span style=\"margin-left: {$margin}px; min-width: 80px; display: inline-block;\">$text</span>";
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
        $output=$text;
        if ($this->return) {
            return $output;
        } else {
            echo $output;
            return $this;
        }
    }

    /**
     * @return DisplayInterface
     */
    public function newline() {
        $output="<br />";
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
    public function italic($text) {
        $output="<em>$text</em>";
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
        $fg="color: $color;";
        $bg=$bgcolor ? "background-color: $bgcolor;" : '';
        $output="<span style=\"{$bg}{$fg}\">$text</span>";
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

    public function __destruct() {
        echo "</body>";
        echo "</html>";
    }

}