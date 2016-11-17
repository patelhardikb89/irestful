<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class PDOEntityPartialSetAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new PDOEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, $password);
        $this->factoryWithInvalidPassword = new PDOEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, 'invalid password');
    }
    
    public function tearDown() {

    }

    public function testCreate_Success() {

        $entityAdapter = $this->factory->create();

        $this->assertTrue($entityAdapter instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters\EntityPartialSetAdapter);

    }

    public function testCreate_withInvalidPassword_throwsEntityException_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            $this->factoryWithInvalidPassword->create();

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
