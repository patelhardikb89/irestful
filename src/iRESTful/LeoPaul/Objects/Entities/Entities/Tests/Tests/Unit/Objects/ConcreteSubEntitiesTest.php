<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteSubEntities;

final class ConcreteSubEntitiesTest extends \PHPUnit_Framework_TestCase {
    private $entityMock;
    private $simpleEntityMock;
    public function setUp() {
        $this->entityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity');
        $this->simpleEntityMock = $this->createMock('iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\SimpleEntity');
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $subEntities = new ConcreteSubEntities();
        $existingEntities = new ConcreteSubEntities([$this->entityMock]);
        $newEntities = new ConcreteSubEntities(null, [$this->simpleEntityMock, $this->entityMock]);

        $this->assertFalse($subEntities->hasExistingEntities());
        $this->assertEquals([], $subEntities->getExistingEntities());
        $this->assertFalse($subEntities->hasNewEntities());
        $this->assertEquals([], $subEntities->getNewEntities());
        $this->assertNull($subEntities->getNewEntityIndex($this->entityMock));
        $this->assertNull($subEntities->getNewEntityIndex($this->simpleEntityMock));
        $this->assertNull($subEntities->getExistingEntityIndex($this->entityMock));

        $firstMergedEntities = $subEntities->merge($existingEntities);

        $this->assertTrue($firstMergedEntities->hasExistingEntities());
        $this->assertEquals([$this->entityMock], $firstMergedEntities->getExistingEntities());
        $this->assertFalse($firstMergedEntities->hasNewEntities());
        $this->assertEquals([], $firstMergedEntities->getNewEntities());
        $this->assertNull($firstMergedEntities->getNewEntityIndex($this->entityMock));
        $this->assertNull($firstMergedEntities->getNewEntityIndex($this->simpleEntityMock));
        $this->assertEquals(0, $firstMergedEntities->getExistingEntityIndex($this->entityMock));

        $secondMergedEntities = $firstMergedEntities->merge($newEntities);

        $this->assertTrue($secondMergedEntities->hasExistingEntities());
        $this->assertEquals([$this->entityMock], $secondMergedEntities->getExistingEntities());
        $this->assertTrue($secondMergedEntities->hasNewEntities());
        $this->assertEquals([$this->simpleEntityMock, $this->entityMock], $secondMergedEntities->getNewEntities());
        $this->assertEquals(1, $secondMergedEntities->getNewEntityIndex($this->entityMock));
        $this->assertEquals(0, $secondMergedEntities->getNewEntityIndex($this->simpleEntityMock));
        $this->assertEquals(0, $secondMergedEntities->getExistingEntityIndex($this->entityMock));

        $secondSameMergedEntities = $secondMergedEntities->merge($newEntities)->merge($existingEntities);

        $this->assertTrue($secondSameMergedEntities->hasExistingEntities());
        $this->assertEquals([$this->entityMock], $secondSameMergedEntities->getExistingEntities());
        $this->assertTrue($secondSameMergedEntities->hasNewEntities());
        $this->assertEquals([$this->simpleEntityMock, $this->entityMock], $secondSameMergedEntities->getNewEntities());
        $this->assertEquals(1, $secondSameMergedEntities->getNewEntityIndex($this->entityMock));
        $this->assertEquals(0, $secondSameMergedEntities->getNewEntityIndex($this->simpleEntityMock));
        $this->assertEquals(0, $secondSameMergedEntities->getExistingEntityIndex($this->entityMock));

        $firstDelete = $secondSameMergedEntities->delete($newEntities);
        $this->assertEquals($existingEntities, $firstDelete);

        $firstDelete = $firstDelete->merge($newEntities);
        $secondDelete = $firstDelete->delete($existingEntities);
        $this->assertEquals($newEntities, $secondDelete);

        $thirdDelete = $secondDelete->delete($newEntities);
        $this->assertEquals(new ConcreteSubEntities(), $thirdDelete);

    }

}
