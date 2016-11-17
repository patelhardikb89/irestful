<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\DatabaseType;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type as ConverterType;

final class ConcreteType implements Type {
    private $name;
    private $databaseType;
    private $databaseConverter;
    private $viewConverter;
    private $method;
    public function __construct(string $name, DatabaseType $databaseType, Converter $databaseConverter, Converter $viewConverter = null, Method $method = null) {

        if (empty($name)) {
            throw new TypeException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->databaseType = $databaseType;
        $this->databaseConverter = $databaseConverter;
        $this->viewConverter = $viewConverter;
        $this->method = $method;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDatabaseType(): DatabaseType {
        return $this->databaseType;
    }

    public function getDatabaseConverter(): Converter {
        return $this->databaseConverter;
    }

    public function getDatabaseConverterMethodName(): string {
        return $this->getMethodName($this->databaseConverter);
    }

    public function hasViewConverter(): bool {
        return !empty($this->viewConverter);
    }

    public function getViewConverter() {
        return $this->viewConverter;
    }

    public function getViewConverterMethodName() {

        if (!$this->hasViewConverter()) {
            return null;
        }

        return $this->getMethodName($this->viewConverter);

    }

    public function hasMethod(): bool {
        return !empty($this->method);
    }

    public function getMethod() {
        return $this->method;
    }

    private function fromNameToMethod($name) {

        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return $name;
    }

    private function getMethodName(Converter $converter) {

        $getConverterTypeName = function(ConverterType $type) {
            if ($type->hasType()) {
                return $type->getType()->getName();
            }

            return $type->getPrimitive()->getName();
        };

        $fromName = $this->getName();
        if ($converter->hasFromType()) {
            $fromType = $converter->fromType();
            $fromName = $getConverterTypeName($fromType);
        }

        $toName = $this->getName();
        if ($converter->hasToType()) {
            $toType = $converter->toType();
            $toName = $getConverterTypeName($toType);
        }

        return $this->fromNameToMethod('from'.ucfirst($fromName).'To'.ucfirst($toName));
    }

}
