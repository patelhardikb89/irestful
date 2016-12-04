<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\DatabaseType;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type as ConverterType;

final class ConcreteType implements Type {
    private $name;
    private $databaseType;
    private $databaseConverter;
    private $viewConverter;
    private $function;
    public function __construct(string $name, DatabaseType $databaseType, Converter $databaseConverter, Converter $viewConverter = null, string $function = null) {

        if (empty($function)) {
            $function = null;
        }

        if (empty($name)) {
            throw new TypeException('The name must be a non-empty string.');
        }

        if (!empty($function) && !function_exists($function)) {
            throw new TypeException('The given function name ('.$function.') is invalid.');
        }

        $this->name = $name;
        $this->databaseType = $databaseType;
        $this->databaseConverter = $databaseConverter;
        $this->viewConverter = $viewConverter;
        $this->function = $function;
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

    public function getDatabaseConverterFunctionName(): string {
        return $this->getFunctionName($this->databaseConverter);
    }

    public function hasViewConverter(): bool {
        return !empty($this->viewConverter);
    }

    public function getViewConverter() {
        return $this->viewConverter;
    }

    public function getViewConverterFunctionName() {

        if (!$this->hasViewConverter()) {
            return null;
        }

        return $this->getFunctionName($this->viewConverter);

    }

    public function hasFunction(): bool {
        return !empty($this->function);
    }

    public function getFunction() {
        return $this->function;
    }

    private function fromNameToFunction($name) {

        $matches = [];
        preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

        foreach($matches[0] as $oneElement) {
            $replacement = strtoupper(str_replace('_', '', $oneElement));
            $name = str_replace($oneElement, $replacement, $name);
        }

        return $name;
    }

    private function getFunctionName(Converter $converter) {

        $getConverterTypeName = function(ConverterType $type) {
            if ($type->hasType()) {
                return $type->getType()->getName();
            }

            if ($type->hasPrimitive()) {
                return $type->getPrimitive()->getName();
            }

            if ($type->isData()) {
                return 'data';
            }

            return $type->getObjectReferenceName();
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

        return $this->fromNameToFunction('from'.ucfirst($fromName).'To'.ucfirst($toName));
    }

}
