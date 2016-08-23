<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Converter;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Converters\Singles\SingleConverter;

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

    public function getData() {
        $output = [];
        if ($this->hasDatabaseConverter()) {
            $output['database'] = $this->getDatabaseConverter()->getData();
        }

        if ($this->hasViewConverter()) {
            $output['view'] = $this->getViewConverter()->getData();
        }

        return $output;

    }

}
