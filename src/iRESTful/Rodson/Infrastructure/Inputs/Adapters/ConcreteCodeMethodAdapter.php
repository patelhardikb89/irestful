<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Code;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteCodeMethod;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method;

final class ConcreteCodeMethodAdapter implements MethodAdapter {
    private $code;
    public function __construct(Code $code) {
        $this->code = $code;
    }

    public function fromStringToMethod($string) {
        return new ConcreteCodeMethod($this->code, $string);
    }

}
