<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Exceptions;

final class SampleNodeException extends \Exception {
    const CODE = 1;
    public function __construct($message, \Exception $parentException = null) {
        parent::__construct($message, self::CODE, $parentException);
    }
}
