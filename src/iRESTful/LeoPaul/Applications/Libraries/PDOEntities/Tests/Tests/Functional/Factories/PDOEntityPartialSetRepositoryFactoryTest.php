<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class PDOEntityPartialSetRepositoryFactoryTest extends \PHPUnit_Framework_TestCase {
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

        $this->factory = new PDOEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, $password);
        $this->factoryWithInvalidPassword = new PDOEntityPartialSetRepositoryFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, 'invalid password');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $repository = $this->factory->create();

        $this->assertTrue($repository instanceof \iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\EntityPartialSetRepository);

    }

    public function testCreate_withInvalidPassword_throwsEntityPartialSetException() {

        $asserted = false;
        try {

            $this->factoryWithInvalidPassword->create();

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
