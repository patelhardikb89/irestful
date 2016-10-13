<?php
namespace iRESTful\Annotations\Infrastructure\Adapters;
use iRESTful\Annotations\Domain\Parameters\Converters\Adapters\ConverterAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Annotations\Domain\Parameters\Converters\Singles\Adapters\SingleConverterAdapter;
use iRESTful\Annotations\Infrastructure\Objects\ConcreteAnnotationParameterConverter;

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
