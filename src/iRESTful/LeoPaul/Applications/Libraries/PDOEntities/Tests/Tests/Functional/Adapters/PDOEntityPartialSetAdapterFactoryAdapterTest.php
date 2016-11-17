<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Tests\Functional\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters\PDOEntityPartialSetAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Factories\PDOEntityPartialSetAdapterFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Exceptions\EntityPartialSetException;

final class PDOEntityPartialSetAdapterFactoryAdapterTest extends \PHPUnit_Framework_TestCase {
    private $data;
    private $adapter;
    private $factory;
    private $factoryWithoutPassword;
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

        $this->data = [
            'transformer_objects' => $transformerObjects,
            'container_class_mapper' => $containerClassMapper,
            'interface_class_mapper' => $interfaceClassMapper,
            'delimiter' => $delimiter,
            'timezone' => $timezone,
            'driver' => $driver,
            'hostname' => $hostname,
            'database' => $database,
            'username' => $username,
            'password' => $password
        ];

        $this->adapter = new PDOEntityPartialSetAdapterFactoryAdapter();
        $this->factory = new PDOEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username, $password);
        $this->factoryWithoutPassword = new PDOEntityPartialSetAdapterFactory($transformerObjects, $containerClassMapper, $interfaceClassMapper, $delimiter, $timezone, $driver, $hostname, $database, $username);
    }

    public function tearDown() {

    }

    public function testFromDataToEntityPartialSetAdapterFactory_Success() {

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        $this->assertEquals($this->factory, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutPassword_Success() {

        unset($this->data['password']);

        $factory = $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        $this->assertEquals($this->factoryWithoutPassword, $factory);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutTransformerObjects_throwsEntityPartialSetException() {

        unset($this->data['transformer_objects']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutContainerClassMapper_throwsEntityPartialSetException() {

        unset($this->data['container_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutInterfaceClassMapper_throwsEntityPartialSetException() {

        unset($this->data['interface_class_mapper']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutDelimiter_throwsEntityPartialSetException() {

        unset($this->data['delimiter']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutTimezone_throwsEntityPartialSetException() {

        unset($this->data['timezone']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutDriver_throwsEntityPartialSetException() {

        unset($this->data['driver']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutHostname_throwsEntityPartialSetException() {

        unset($this->data['hostname']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutDatabase_throwsEntityPartialSetException() {

        unset($this->data['database']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToEntityPartialSetAdapterFactory_withoutUsername_throwsEntityPartialSetException() {

        unset($this->data['username']);

        $asserted = false;
        try {

            $this->adapter->fromDataToEntityPartialSetAdapterFactory($this->data);

        } catch (EntityPartialSetException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
