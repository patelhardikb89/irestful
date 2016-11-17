<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Unit\Factories;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Factories\V4UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Helpers\UuidClass;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class V4UuidFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    public function setUp() {
        $this->factory = new V4UuidFactory('iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Helpers\UuidClass');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $factory = new V4UuidFactory();
        $uuid = $factory->create();

        $this->assertTrue($uuid instanceof \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid);

    }

    public function testCreate_withHelperUuid_Success() {

        $uuid = $this->factory->create();

        $this->assertTrue($uuid instanceof \iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Objects\ConcreteUuid);

    }

    public function testCreate_withHelperUuid_throwsUnsatisfiedDependencyException_throwsUnsatisfiedDependencyException() {

        UuidClass::willThrowException();

        $asserted = false;
        try {

            $this->factory->create();

        } catch (UuidException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
