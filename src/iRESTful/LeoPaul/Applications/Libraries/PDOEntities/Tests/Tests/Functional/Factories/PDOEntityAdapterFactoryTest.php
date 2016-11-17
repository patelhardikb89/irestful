<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class PDOEntityAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $factory;
    private $factoryWithInvalidPassword;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();

        $transformerObjects = [
            'some' => 'objects'
        ];

        $containerClassMapper = [
            'my_container' => '/Some/ClassName'
        ];

        $interfaceClassMapper = [
            'MyInterface' => '/Some/ClassName'
        ];

        $delimiter = '___';
        $timezone = 'America/Montreal';
        $driver = getenv('DB_DRIVER');
        $hostname = getenv('DB_SERVER');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $database = getenv('DB_NAME');

        $this->factory = new PDOEntityAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, $password);
        $this->factoryWithInvalidPassword = new PDOEntityAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, 'invalid password');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $entityAdapter = $this->factory->create();

        $this->assertTrue($entityAdapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\EntityAdapter);

    }

    public function testCreate_withInvalidPassword_throwsEntityException() {

        $asserted = false;
        try {

            $this->factoryWithInvalidPassword->create();

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
