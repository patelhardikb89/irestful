<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Samples\Sample;
use iRESTful\DSLs\Domain\Projects\Objects\Samples\Exceptions\SampleException;

final class ConcreteObjectSample implements Sample {
    private $data;
    public function __construct(array $data) {

        $verify = function(array $data) use(&$verify) {
            foreach($data as $value) {

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
