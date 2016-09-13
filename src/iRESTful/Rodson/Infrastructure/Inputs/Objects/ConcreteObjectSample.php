<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Samples\Sample;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Samples\Exceptions\SampleException;

final class ConcreteObjectSample implements Sample {
    private $data;
    public function __construct(array $data) {

        $verify = function(array $data) use(&$verify) {
            foreach($data as $keyname => $value) {

                if (is_null($keyname) || (!is_string($keyname) && !is_int($keyname))) {
                    throw new SampleException('The keynames of the data must be non-empty strings/integers.');
                }

                if (is_array($value)) {
                    $verify($value);
                    continue;
                }

                if (is_object($value)) {
                    throw new SampleException('The valus of the data cannot be objects.');
                }

            }
        };

        $verify($data);
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

}
