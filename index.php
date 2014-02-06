<?php
require('BranchLog.php');
require('DisplayAdapter.php');
require('Config.php');

$paths=explode(':', PATH_LIST);

$branches=explode(':', BRANCH_COMPARE_LIST);

$display=DisplayAdapter::create(isset($_SERVER['REQUEST_URI']) ? 'browser' : 'console');

foreach ($branches as $branch) {
    printStatsFor($paths, $branch, $display);
}

function printStatsFor($paths, $branch, $display) {
    $log=new BranchLog($paths, BASE_BRANCH);
    $shortlog=$log->getShortlogFor($branch);
    /**
     * @var DisplayInterface $display
     */
    $display->bold("$branch")->newline();
    foreach ($shortlog as $path=>$pathlog) {
        $path=basename($path);
        $data=$log->parseLog($pathlog);
        if (!is_array($data)) {
            $display
                ->idented(
                    $display
                        ->setReturn(true)
                        ->color("$path", 'red')
                    . $display->setReturn(false)
                )
                ->idented(
                    $display
                        ->setReturn(true)
                        ->color("Invalid path", 'white', 'red')
                    . $display->setReturn(false)
                )
            ->newline();

            continue;
        }
        $display
            ->idented(
                $display
                    ->setReturn(true)
                    ->color("$path", 'yellow')
                . $display->setReturn(false)
            );
        if (count($data['commits']) > 0) {
            $display->idented(
                $display
                    ->setReturn(true)
                    ->color(count($data['commits']), 'red')
                . " commits from "
                . $display
                    ->color(count($data['authors']), 'cyan')
                . $display->setReturn(false)
                . " authors"
            );
        } else {
            $display->idented(
                $display
                    ->setReturn(true)
                    ->color("No difference", 'green')
                . $display->setReturn(false)
            );
        }
        $display->newline();
    }
    $display->newline();

}
