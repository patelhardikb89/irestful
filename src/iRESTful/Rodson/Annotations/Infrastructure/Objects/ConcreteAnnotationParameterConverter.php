<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Objects;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Converter;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Singles\SingleConverter;

final class ConcreteAnnotationParameterConverter implements Converter {
    private $databaseConverter;
    private $viewConverter;
    public function __construct(SingleConverter $databaseConverter = null, SingleConverter $viewConverter = null) {

        if (empty($databaseConverter) && empty($viewConverter)) {
            throw new ConverterException('The databaseConverter and the viewConverter cannot be both empty.');
        }

        $this->databaseConverter = $databaseConverter;
        $this->viewConverter = $viewConverter;
    }

    public function hasDatabaseConverter() {
        return !empty($this->databaseConverter);
    }

    public function getDatabaseConverter() {
        return $this->databaseConverter;
    }

    public function hasViewConverter() {
        return !empty($this->viewConverter);
    }

    public function getViewConverter() {
        return $this->viewConverter;
    }

}
