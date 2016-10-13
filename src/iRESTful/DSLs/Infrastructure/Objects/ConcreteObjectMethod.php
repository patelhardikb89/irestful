<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\DSLs\Domain\Projects\Codes\Methods\Method as CodeMethod;
use iRESTful\DSLs\Domain\Projects\Objects\Methods\Exceptions\MethodException;

final class ConcreteObjectMethod implements Method {
    private $name;
    private $codeMethod;
    public function __construct(string $name, CodeMethod $codeMethod) {

        if (empty($name)) {
            throw new MethodException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->codeMethod = $codeMethod;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getMethod(): CodeMethod {
        return $this->codeMethod;
    }

}
