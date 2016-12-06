<?php
$baseDir = getcwd();
include_once($baseDir.'/vendor/autoload.php');
\Rodson\Compiler::setArguments($argv);
\Rodson\Compiler::compile($argv);
