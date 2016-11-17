<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Adapters\ForeignKeyAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteForeignKey;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Exceptions\ForeignKeyException;

final class ConcreteForeignKeyAdapter implements ForeignKeyAdapter {
    private $tableAdapter;
    public function __construct(TableAdapter $tableAdapter) {
        $this->tableAdapter = $tableAdapter;
    }

    public function fromContainerNameToForeignKey($containerName) {
        $table = $this->tableAdapter->fromDataToTable([
            'container' => $containerName
        ]);

        return new ConcreteForeignKey($table);
    }

    public function fromDataToForeignKey(array $data) {

        if (!isset($data['argument_metadata'])) {
            throw new ForeignKeyException('The argument_metadata keyname is mandatory in order to convert data to a ForeignKey object.');
        }

        if (!isset($data['parent_class_metadata'])) {
            throw new ForeignKeyException('The parent_class_metadata keyname is mandatory in order to convert data to a ForeignKey object.');
        }

        try {

            $argumentMetaData = $data['argument_metadata'];
            if ($argumentMetaData->hasClassMetaData()) {
                $classMetaData = $argumentMetaData->getClassMetaData();
                if (!$classMetaData->hasContainerName()) {
                    return null;
                }

                $containerName = $classMetaData->getContainerName();
                return $this->fromContainerNameToForeignKey($containerName);
            }

            if ($argumentMetaData->isRecursive()) {
                $table = $this->tableAdapter->fromClassMetaDataToTable($data['parent_class_metadata']);
                return new ConcreteForeignKey($table);
            }

            return null;

        } catch (TableException $exception) {
            throw new ForeignKeyException('There was an exception while converting data to a Table object.', $exception);
        }
    }

}
