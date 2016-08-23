<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Views\View;
use iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Views\Exceptions\ViewException;

final class ConcreteControllerHttpRequestView implements View {
    private $isJson;
    public function __construct($isJson) {

        $amount = ($isJson ? 1 : 0);
        if ($amount != 1) {
            throw new ViewException('There must be 1 valid view type.  '.$amount.' given.');
        }

        $this->isJson = $isJson;

    }

    public function isJson() {
        return $this->isJson;
    }

    public function getData() {
        return [
            'is_json' => $this->isJson()
        ];
    }

}
