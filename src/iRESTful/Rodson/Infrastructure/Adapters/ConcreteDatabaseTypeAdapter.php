<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteDatabaseType;
use iRESTful\Rodson\Domain\Types\Databases\Binaries\Adapters\BinaryAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Floats\Adapters\FloatAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Adapters\IntegerAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Strings\Adapters\StringAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;
use iRESTful\Rodson\Domain\Types\Databases\Binaries\Exceptions\BinaryException;
use iRESTful\Rodson\Domain\Types\Databases\Floats\Exceptions\FloatException;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Exceptions\IntegerException;
use iRESTful\Rodson\Domain\Types\Databases\Strings\Exceptions\StringException;

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
        if ($data['name'] == 'boolean') {
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
            if ($data['name'] == 'integer') {
                $integer = $this->integerAdapter->fromDataToInteger($data);
            }

            $string = null;
            if ($data['name'] == 'string') {
                $string = $this->stringAdapter->fromDataToString($data);
            }

            return new ConcreteDatabaseType($data['name'], $hasBoolean, $binary, $float, $integer, $string);

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
