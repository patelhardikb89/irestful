<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteSimpleEntity;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteSimpleEntityTest extends \PHPUnit_Framework_TestCase {
    private $uuidMock;
    private $createdOn;
    private $title;
    private $description;
    private $slug;
    public function setUp() {
        $this->uuidMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid');
        $this->createdOn = new \DateTime();
        $this->title = 'This is some title';
        $this->description = 'This is some description';
        $this->slug = 'this-is-a-slug';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $simpleEntity = new ConcreteSimpleEntity($this->uuidMock, $this->createdOn, $this->title, $this->description, $this->slug);

        $this->assertEquals($this->uuidMock, $simpleEntity->getUuid());
        $this->assertEquals($this->createdOn, $simpleEntity->createdOn());
        $this->assertEquals($this->title, $simpleEntity->getTitle());
        $this->assertEquals($this->description, $simpleEntity->getDescription());
        $this->assertEquals($this->slug, $simpleEntity->getSLug());
        $this->assertFalse($simpleEntity->hasSubEntities());
        $this->assertNull($simpleEntity->getSubEntities());

    }

    public function testCreate_withSubEntities_Success() {

        $firstSimpleEnity = new ConcreteSimpleEntity($this->uuidMock, $this->createdOn, $this->title, $this->description, $this->slug);
        $secondSimpleEnity = new ConcreteSimpleEntity($this->uuidMock, $this->createdOn, $this->title, $this->description, $this->slug);

        $subEntities = [$firstSimpleEnity, $secondSimpleEnity];
        $simpleEntity = new ConcreteSimpleEntity($this->uuidMock, $this->createdOn, $this->title, $this->description, $this->slug, $subEntities);

        $this->assertEquals($this->uuidMock, $simpleEntity->getUuid());
        $this->assertEquals($this->createdOn, $simpleEntity->createdOn());
        $this->assertEquals($this->title, $simpleEntity->getTitle());
        $this->assertEquals($this->description, $simpleEntity->getDescription());
        $this->assertEquals($this->slug, $simpleEntity->getSLug());
        $this->assertTrue($simpleEntity->hasSubEntities());
        $this->assertEquals($subEntities, $simpleEntity->getSubEntities());

    }

    public function testCreate_withInvalidSubEntities_throwsEntityException() {

        $asserted = false;
        try {

            new ConcreteSimpleEntity($this->uuidMock, $this->createdOn, $this->title, $this->description, $this->slug, [new \DateTime()]);
        } catch (EntityException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
