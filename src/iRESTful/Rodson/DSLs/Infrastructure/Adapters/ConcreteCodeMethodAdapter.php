<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Code;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteCodeMethod;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Method;

final class ConcreteCodeMethodAdapter implements MethodAdapter {
    private $code;
    public function __construct(Code $code) {
        $this->code = $code;
    }

    public function fromStringToMethod($string) {
        return new ConcreteCodeMethod($this->code, $string);
    }

}
