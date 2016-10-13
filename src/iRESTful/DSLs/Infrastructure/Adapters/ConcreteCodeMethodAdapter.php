<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\DSLs\Domain\Projects\Codes\Code;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteCodeMethod;
use iRESTful\DSLs\Domain\Projects\Codes\Methods\Method;

final class ConcreteCodeMethodAdapter implements MethodAdapter {
    private $code;
    public function __construct(Code $code) {
        $this->code = $code;
    }

    public function fromStringToMethod($string) {
        return new ConcreteCodeMethod($this->code, $string);
    }

}
