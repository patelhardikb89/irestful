<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Test;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Transform;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Exceptions\TestException;

final class ConcreteSpecificClassTest implements Test {
    private $transform;
    public function __construct(Transform $transform = null) {

        $amount = (empty($transform) ? 0 : 1);
        if ($amount != 1) {
            throw new TestException('There must be 1 test.  '.$amount.' given.');
        }

        $this->transform = $transform;
    }

    public function hasTransform() {
        return !empty($this->transform);
    }

    public function getTransform() {
        return $this->transform;
    }

}
