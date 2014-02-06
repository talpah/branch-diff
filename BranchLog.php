<?php

/**
 * Created by PhpStorm.
 * User: cosmin
 * Date: 2/6/14
 * Time: 10:31 AM
 */
class BranchLog {
    private $preCommand="git fetch origin";
    private $command="git log --no-merges --oneline --format='%an :: %s' origin/%BASEBRANCH%..origin/%BRANCH%";
    private $pathList=null;

    function __construct($paths, $baseBranch) {
        if (!is_array($paths)) {
            $paths=array($paths);
        }

        $this->pathList=$paths;
        $this->command=str_replace('%BASEBRANCH%', $baseBranch, $this->command);

    }

    function parseLog($log) {
        $authors=$commits=array();
        if (!is_array($log)) {
            return $log;
        }
        foreach ($log as $logline) {
            $logline=explode(' :: ', $logline);
            $author=array_shift($logline);
            $authors[$author]=$author;
            $commits[]=array('author'=>$author, 'subject'=>implode(' ', $logline));
        }
        return array('authors'=>$authors, 'commits'=>$commits);
    }

    function getShortlogFor($branch) {
        $command=str_replace('%BRANCH%', $branch, $this->command);
        $results=array();
        foreach ($this->pathList as $path) {
            if (is_dir($path)) {
                chdir($path);
//                exec($this->preCommand);
                exec($command, $results[$path]);
            } else {
                $results[$path]='Invalid path';
            }
        }
        return $results;
    }
}