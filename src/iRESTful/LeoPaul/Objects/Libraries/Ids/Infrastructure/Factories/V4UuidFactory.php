<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Factories\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

final class V4UuidFactory implements UuidFactory {

    private $uuidClass;
    public function __construct($uuidClass = 'Ramsey\Uuid\Uuid') {
        $this->uuidClass = $uuidClass;
    }

    public function create() {

        try {

            $v4 = call_user_func(array($this->uuidClass, 'uuid4'));
            return new ConcreteUuid($v4->toString());

        } catch (UnsatisfiedDependencyException $exception) {
            throw new UuidException('It was impossible to generate a Uuid (version 4).', $exception);
        }
    }

}
