<?php
namespace Rodson;
use iRESTful\Rodson\Applications\Infrastructure\Factories\ConcreteApplicationFactory;

final class Compiler {
    private static $arguments;
    public static function setArguments(array $arguments) {
        self::$arguments = $arguments;
    }

    public static function compile() {

        if (empty(self::$arguments)) {
            self::$arguments = [
                'bin/rodson.php',
                '--input',
                'src/rodson.json',
                '--output',
                'build'
            ];
        }

        $parse = function(array $arguments) {

            $output = [];
            foreach($arguments as $index => $oneArgument) {

                if (strpos($oneArgument, '--') === 0) {
                    $output[substr($oneArgument, 2)] = $arguments[$index + 1];
                }

            }

            return $output;

        };

        $render = function($message) {
            die(PHP_EOL.$message.PHP_EOL.PHP_EOL);
        };

        $version = phpversion();
        if (strpos($version, '7') !== 0) {
            $render('Your PHP version is: '.$version.'.  This CLI application requires PHP 7+.');
        }

        $arguments = $parse(self::$arguments);
        if (!isset($arguments['input'])) {
            $render('The rodson application must receive an --input file path as argument.');
        }

        if (!isset($arguments['output'])) {
            $render('The rodson application must receive an --output folder as argument.');
        }

        $baseDir = getcwd();
        $inputFile = (strpos($arguments['input'], '/') === 0) ? $arguments['input'] : $baseDir.'/'.$arguments['input'];
        if (!file_exists($inputFile)) {
            $render('The given --input file is invalid: '.$inputFile);
        }

        $outputDir = (strpos($arguments['output'], '/') === 0) ? $arguments['output'] : $baseDir.'/'.$arguments['output'];
        if (!is_dir($outputDir) || !file_exists($outputDir)) {
            if (!@mkdir($outputDir, 0777, true)) {
                $render('The given --output directory is invalid: '.$outputDir.' and could not be created.  Please manually create it and chmod it to 777.');
            }

        }

        $templatePath = __DIR__.'/../../templates/rodson/code/php';
        $timezone = 'America/Montreal';
        $applicationFactory = new ConcreteApplicationFactory($timezone, $templatePath, $inputFile, $outputDir);
        $applicationFactory->create()->execute();

        $render('Done!  You code is ready in this directory: '.$outputDir.PHP_EOL);
    }

};
