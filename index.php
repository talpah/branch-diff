<?php
require('BranchLog.php');
require('DisplayAdapter.php');
require('Config.php');

$paths=explode(':', PATH_LIST);

$branches=explode(':', BRANCH_COMPARE_LIST);

$display=DisplayAdapter::create(isset($_SERVER['REQUEST_URI']) ? 'browser' : 'console');

$display->bold(
    "Using ".
    $display->setReturn(true)->color(BASE_BRANCH, 'cyan').
    " as base." .
    $display->setReturn(false)
);
$display->newline()->newline();

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
        $hasDiff=count($data['commits']) > 0;
        $display
            ->idented(
                $display
                    ->setReturn(true)
                    ->color("$path", $hasDiff ? 'yellow' : 'gray')
                . $display->setReturn(false)
            );
        if ($hasDiff) {
            $display->idented(
                $display
                    ->setReturn(true)
                    ->idented(
                        $display->color(count($data['commits']), 'red')
                    )
                . $display->idented(" commits from ")
                . $display
                    ->idented(
                        $display->color(count($data['authors']), 'cyan')
                    )
                . $display->idented(" authors")
                . $display->setReturn(false)

            );
        } else {
            $display->idented(
                $display
                    ->setReturn(true)
                    ->idented($display->color("--", 'gray'))
                . $display->setReturn(false)
            );
        }
        $display->newline();
    }
    $display->newline();

}
