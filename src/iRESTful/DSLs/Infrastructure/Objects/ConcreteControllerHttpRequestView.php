<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Views\View;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Views\Exceptions\ViewException;

final class ConcreteControllerHttpRequestView implements View {
    private $isJson;
    public function __construct(bool $isJson) {

        $amount = ($isJson ? 1 : 0);
        if ($amount != 1) {
            throw new ViewException('There must be 1 valid view type.  '.$amount.' given.');
        }

        $this->isJson = $isJson;

    }

    public function isJson(): bool {
        return $this->isJson;
    }

}
