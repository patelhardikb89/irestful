<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Adapters;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Adapters\ConverterAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Singles\Adapters\SingleConverterAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Objects\ConcreteAnnotationParameterConverter;

final class ConcreteAnnotationParameterConverterAdapter implements ConverterAdapter {
    private $singleConverterAdapter;
    public function __construct(SingleConverterAdapter $singleConverterAdapter) {
        $this->singleConverterAdapter = $singleConverterAdapter;
    }

    public function fromTypeToConverter(Type $type) {

        $viewConverter = null;
        if ($type->hasViewConverter()) {
            $viewConverter = $this->singleConverterAdapter->fromTypeToViewSingleConverter($type);
        }

        $databaseConverter = $this->singleConverterAdapter->fromTypeToDatabaseSingleConverter($type);
        return new ConcreteAnnotationParameterConverter($databaseConverter, $viewConverter);

    }

}
