<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteEntity;
use iRESTful\Rodson\Domain\Entities\Exceptions\EntityException;

final class ConcreteEntityTest extends \PHPUnit_Framework_TestCase {
    private $propertyMock;
    private $databaseMock;
    private $name;
    private $properties;
    public function setUp() {
        $this->propertyMock = $this->getMock('iRESTful\Rodson\Domain\Entities\Properties\Property');
        $this->databaseMock = $this->getMock('iRESTful\Rodson\Domain\Databases\Database');

        $this->name = 'MyEntity';
        $this->properties = [
            $this->propertyMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $entity = new ConcreteEntity($this->name, $this->properties, $this->databaseMock);

        $this->assertEquals($this->name, $entity->getName());
        $this->assertEquals($this->properties, $entity->getProperties());
        $this->assertEquals($this->databaseMock, $entity->getDatabase());

    }

    public function testCreate_withInvalidIndexInProperties_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntity($this->name, ['some' => $this->propertyMock], $this->databaseMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneInvalidProperty_throwsEntityException() {

        $this->properties[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteEntity($this->name, $this->properties, $this->databaseMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyProperties_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntity($this->name, [], $this->databaseMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntity('', $this->properties, $this->databaseMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteEntity(new \DateTime(), $this->properties, $this->databaseMock);

        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
