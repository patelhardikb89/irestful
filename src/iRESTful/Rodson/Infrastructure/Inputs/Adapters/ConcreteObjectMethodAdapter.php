<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Adapters\MethodAdapter as CodeMethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteObjectMethod;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Methods\Exceptions\MethodException;

final class ConcreteObjectMethodAdapter implements MethodAdapter {
    private $codeMethodAdapter;
    public function __construct(CodeMethodAdapter $codeMethodAdapter) {
        $this->codeMethodAdapter = $codeMethodAdapter;
    }

    public function fromDataToMethods(array $data) {
        $output = [];
        foreach($data as $name => $method) {
            $output[] = $this->fromDataToMethod([
                'name' => $name,
                'method' => $method
            ]);
        }

        return $output;

    }

    public function fromDataToMethod(array $data) {

        if (!isset($data['name'])) {
            throw new MethodException('The name keyname is mandatory in order to convert data to a Method object.');
        }

        if (!isset($data['method'])) {
            throw new MethodException('The method keyname is mandatory in order to convert data to a Method object.');
        }

        $codeMethod = $this->codeMethodAdapter->fromStringToMethod($data['method']);
        return new ConcreteObjectMethod($data['name'], $codeMethod);

    }

}
