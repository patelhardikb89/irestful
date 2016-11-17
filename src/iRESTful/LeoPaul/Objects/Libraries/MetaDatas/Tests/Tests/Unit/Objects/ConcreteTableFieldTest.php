<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTableField;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TypeHelper;

final class ConcreteTableFieldTest extends \PHPUnit_Framework_TestCase {
    private $foreignKeyMock;
    private $typeMock;
    private $name;
    private $default;
    private $typeHelper;
    public function setUp() {
        $this->foreignKeyMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey');
        $this->typeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');

        $this->name = 'some_field';
        $this->default = 'random_default';

        $this->typeHelper = new TypeHelper($this, $this->typeMock);

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $field = new ConcreteTableField($this->name, $this->typeMock, false, false, false);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertFalse($field->isUnique());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isPrimaryKey_typeIsBinary_Success() {

        $this->typeHelper->expectsHasBinary_Success(true);

        $field = new ConcreteTableField($this->name, $this->typeMock, true, true, false);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertTrue($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isPrimaryKey_typeIsBinary_isNotUnique_stillShowsAsUique_Success() {

        $this->typeHelper->expectsHasBinary_Success(true);

        $field = new ConcreteTableField($this->name, $this->typeMock, true, false, false);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertTrue($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isPrimaryKey_typeIsInteger_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);

        $field = new ConcreteTableField($this->name, $this->typeMock, true, true, false);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertTrue($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isPrimaryKey_typeNotBinary_typeNotInteger_throwsFieldException() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, true, true, false);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withForeignKey_Success() {

        $field = new ConcreteTableField($this->name, $this->typeMock, false, false, false, null, $this->foreignKeyMock);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertFalse($field->isUnique());
        $this->assertFalse($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertTrue($field->hasForeignKey());
        $this->assertEquals($this->foreignKeyMock, $field->getForeignKey());

    }

    public function testCreate_isNullable_withoutDefault_Success() {

        $field = new ConcreteTableField($this->name, $this->typeMock, false, false, true);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertFalse($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertFalse($field->hasDefault());
        $this->assertNull($field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isNullable_withNullDefault_Success() {

        $field = new ConcreteTableField($this->name, $this->typeMock, false, false, true, 'null');

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertFalse($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertTrue($field->hasDefault());
        $this->assertEquals('null', $field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isUnique_isNullable_withStringDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsHasString_Success(true);

        $field = new ConcreteTableField($this->name, $this->typeMock, false, true, true, $this->default);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertTrue($field->hasDefault());
        $this->assertEquals($this->default, $field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isUnique_isNullable_withIntegerDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsHasString_Success(false);

        $field = new ConcreteTableField($this->name, $this->typeMock, false, true, true, 22);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertTrue($field->hasDefault());
        $this->assertEquals(22, $field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isUnique_isNullable_withFloatDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(true);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsHasString_Success(false);

        $field = new ConcreteTableField($this->name, $this->typeMock, false, true, true, (float) 22/30);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertTrue($field->hasDefault());
        $this->assertEquals((float) 22/30, $field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isUnique_isNullable_withNumericDefault_Success() {

        $field = new ConcreteTableField($this->name, $this->typeMock, false, true, true, 45);

        $this->assertEquals($this->name, $field->getName());
        $this->assertEquals($this->typeMock, $field->getType());
        $this->assertFalse($field->isPrimaryKey());
        $this->assertTrue($field->isUnique());
        $this->assertTrue($field->isNullable());
        $this->assertTrue($field->hasDefault());
        $this->assertEquals(45, $field->getDefault());
        $this->assertFalse($field->hasForeignKey());
        $this->assertNull($field->getForeignKey());

    }

    public function testCreate_isNotNullable_withNullDefault_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, false, 'null');

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_isUnique_isNotNullable_withoutDefault_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, false, 'null');

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidDefault_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, new \DateTime());

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidName_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField('InvalidName9', $this->typeMock, false, true, true);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyName_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField('', $this->typeMock, false, true, true);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringName_throwsFieldException() {

        $asserted = false;
        try {

            new ConcreteTableField(new \DateTime(), $this->typeMock, false, true, true);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsString_withIntegerDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsHasString_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, 22);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsFloat_withIntegerDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, 22);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsInteger_withStringDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, 'random');

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsFloat_withStringDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, 'random');

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsInteger_withFloatDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, (float) 22/40);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_typeIsString_withFloatDefault_Success() {

        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsHasString_Success(true);

        $asserted = false;
        try {

            new ConcreteTableField($this->name, $this->typeMock, false, true, true, (float) 22/40);

        } catch (FieldException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
