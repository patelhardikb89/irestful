<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Adapters\ConverterAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\Adapters\SingleConverterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotationParameterConverter;

final class ConcreteAnnotationParameterConverterAdapter implements ConverterAdapter {
    private $singleConverterAdapter;
    public function __construct(SingleConverterAdapter $singleConverterAdapter) {
        $this->singleConverterAdapter = $singleConverterAdapter;
    }

    public function fromTypeToConverter(Type $type) {

        $databaseConverter = null;
        if ($type->hasDatabaseAdapter()) {
            $databaseConverter = $this->singleConverterAdapter->fromTypeToDatabaseSingleConverter($type);
        }

        $viewConverter = null;
        if ($type->hasViewAdapter()) {
            $viewConverter = $this->singleConverterAdapter->fromTypeToViewSingleConverter($type);
        }

        if (empty($databaseConverter) && empty($viewConverter)) {
            return null;
        }

        return new ConcreteAnnotationParameterConverter($databaseConverter, $viewConverter);

    }

}
