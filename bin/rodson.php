<?php
$baseDir = getcwd();
include_once($baseDir.'/vendor/autoload.php');
\Rodson\Compiler::compile($argv);
