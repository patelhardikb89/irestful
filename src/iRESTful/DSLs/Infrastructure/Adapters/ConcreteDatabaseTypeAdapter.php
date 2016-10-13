<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDatabaseType;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\Adapters\BinaryAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Floats\Adapters\FloatAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\Adapters\IntegerAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Adapters\StringAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Exceptions\DatabaseTypeException;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Binaries\Exceptions\BinaryException;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Floats\Exceptions\FloatException;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Integers\Exceptions\IntegerException;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Exceptions\StringException;

final class ConcreteDatabaseTypeAdapter implements DatabaseTypeAdapter {
    private $binaryAdapter;
    private $floatAdapter;
    private $integerAdapter;
    private $stringAdapter;
    public function __construct(BinaryAdapter $binaryAdapter, FloatAdapter $floatAdapter, IntegerAdapter $integerAdapter, StringAdapter $stringAdapter) {
        $this->binaryAdapter = $binaryAdapter;
        $this->floatAdapter = $floatAdapter;
        $this->integerAdapter = $integerAdapter;
        $this->stringAdapter = $stringAdapter;
    }

    public function fromDataToDatabaseType(array $data) {

        if (!isset($data['name'])) {
            throw new DatabaseTypeException('The name keyname is mandatory in order to convert the data to a DatabaseType object.');
        }

        $hasBoolean = false;
        if ($data['name'] == 'bool') {
            $hasBoolean = true;
        }

        try {

            $binary = null;
            if ($data['name'] == 'binary') {
                $binary = $this->binaryAdapter->fromDataToBinary($data);
            }

            $float = null;
            if ($data['name'] == 'float') {
                $float = $this->floatAdapter->fromDataToFloat($data);
            }

            $integer = null;
            if ($data['name'] == 'int') {
                $integer = $this->integerAdapter->fromDataToInteger($data);
            }

            $string = null;
            if ($data['name'] == 'string') {
                $string = $this->stringAdapter->fromDataToString($data);
            }

            return new ConcreteDatabaseType($hasBoolean, $binary, $float, $integer, $string);

        } catch (BinaryException $exception) {
            throw new DatabaseTypeException('There was an exception while converting data to a Binary object.', $exception);
        } catch (FloatException $exception) {
            throw new DatabaseTypeException('There was an exception while converting data to a Float object.', $exception);
        } catch (IntegerException $exception) {
            throw new DatabaseTypeException('There was an exception while converting data to an Integer object.', $exception);
        } catch (StringException $exception) {
            throw new DatabaseTypeException('There was an exception while converting data to a String object.', $exception);
        }

    }

}
