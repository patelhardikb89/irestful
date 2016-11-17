<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeBinary;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeFloat;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeInteger;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTypeString;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters\PDOTableFieldTypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Objects\TypeHelper;

final class PDOTableFieldTypeAdapterTest extends \PHPUnit_Framework_TestCase {
    private $typeMock;
    private $specificBitSize;
    private $maxBitSize;
    private $binary;
    private $binaryWithSpecificBitSize;
    private $binaryWithMaxBitSize;
    private $digitAmount;
    private $precision;
    private $float;
    private $specificCharSize;
    private $maximumCharSize;
    private $string;
    private $stringWithSpecificCharSize;
    private $stringWithMaxCharSize;
    private $adapter;
    private $typeHelper;
    public function setUp() {
        $this->typeMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type');

        $this->specificBitSize = 64;
        $this->maxBitSize = 128;

        $this->binary = new ConcreteTypeBinary();
        $this->binaryWithSpecificBitSize = new ConcreteTypeBinary($this->specificBitSize);
        $this->binaryWithMaxBitSize = new ConcreteTypeBinary(null, $this->maxBitSize);

        $this->digitAmount = 20;
        $this->precision = 8;
        $this->float = new ConcreteTypeFloat($this->digitAmount, $this->precision);

        $this->specificCharSize = 2;
        $this->maximumCharSize = 255;

        $this->string = new ConcreteTypeString();
        $this->stringWithSpecificCharSize = new ConcreteTypeString($this->specificCharSize);
        $this->stringWithMaxCharSize = new ConcreteTypeString(null, $this->maximumCharSize);

        $this->adapter = new PDOTableFieldTypeAdapter();

        $this->typeHelper = new TypeHelper($this, $this->typeMock);

    }

    public function tearDown() {

    }

    public function testFromTypeToTypeInSqlQueryLine_typeIsBinary_Success() {

        $this->typeHelper->expectsHasBinary_Success(true);
        $this->typeHelper->expectsGetBinary_Success($this->binary);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('blob', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_typeIsBinary_withSpecificBitSize_Success() {

        $this->typeHelper->expectsHasBinary_Success(true);
        $this->typeHelper->expectsGetBinary_Success($this->binaryWithSpecificBitSize);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('binary (8)', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_typeIsBinary_withMaxBitSize_Success() {

        $this->typeHelper->expectsHasBinary_Success(true);
        $this->typeHelper->expectsGetBinary_Success($this->binaryWithMaxBitSize);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('varbinary (16)', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withFloat_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(true);
        $this->typeHelper->expectsGetFloat_Success($this->float);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('decimal (20, 8)', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withInteger_isTinyInt_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsGetInteger_Success(new ConcreteTypeInteger(8));

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('tinyint', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withInteger_isSmallInt_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsGetInteger_Success(new ConcreteTypeInteger(16));

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('smallint', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withInteger_isMediumInt_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsGetInteger_Success(new ConcreteTypeInteger(24));

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('mediumint', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withInteger_isInt_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsGetInteger_Success(new ConcreteTypeInteger(32));

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('int', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withInteger_isBigInt_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(true);
        $this->typeHelper->expectsGetInteger_Success(new ConcreteTypeInteger(64));

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('bigint', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withString_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsGetString_Success($this->string);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('text', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withString_withSpecificCharSize_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsGetString_Success($this->stringWithSpecificCharSize);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('char (2)', $line);

    }

    public function testFromTypeToTypeInSqlQueryLine_withString_withMaxCharSize_Success() {

        $this->typeHelper->expectsHasBinary_Success(false);
        $this->typeHelper->expectsHasFloat_Success(false);
        $this->typeHelper->expectsHasInteger_Success(false);
        $this->typeHelper->expectsGetString_Success($this->stringWithMaxCharSize);

        $line = $this->adapter->fromTypeToTypeInSqlQueryLine($this->typeMock);

        $this->assertEquals('varchar (255)', $line);

    }

}
