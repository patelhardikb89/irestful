<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\CustomMethods\SourceCodes\SourceCode;
use iRESTful\Classes\Domain\CustomMethods\SourceCodes\Exceptions\SourceCodeException;

final class ConcreteCustomMethodSourceCode implements SourceCode {
    private $lines;
    public function __construct(array $data) {

        $tab = '    ';
        $process = function(array $lines, $currentTab = '') use(&$tab, &$process) {

            if (empty($lines)) {
                return '';
            }

            $output = '';
            $newTab = $currentTab.$tab;
            foreach($lines as $oneLine) {
                if (is_array($oneLine)) {
                    $output .= $process($oneLine, $newTab);
                    continue;
                }

                $output .= $currentTab.$oneLine.PHP_EOL;
            }

            return $output;

        };

        $lines = explode(PHP_EOL, $process($data));
        if (!empty($lines)) {
            foreach($lines as $oneLine) {
                if (!empty($oneLine) && !is_string($oneLine)) {
                    throw new SourceCodeException('The lines array must only contain string lines.');
                }
            }
        }

        $this->lines = $lines;
    }

    public function hasLines() {
        return !empty($this->lines);
    }

    public function getLines() {
        return $this->lines;
    }
}
