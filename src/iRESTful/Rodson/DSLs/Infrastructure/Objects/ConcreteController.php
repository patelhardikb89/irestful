<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Exceptions\ControllerException;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\View;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;

final class ConcreteController implements Controller {
    private $name;
    private $pattern;
    private $view;
    private $functionName;
    public function __construct(string $name, string $pattern, View $view, string $functionName) {

        if (empty($pattern)) {
            throw new ControllerException('The pattern must be a non-empty string.');
        }

        if (empty($name)) {
            throw new ControllerException('The name must be a non-empty string.');
        }

        if (empty($functionName)) {
            throw new ControllerException('The functionName must be a non-empty string.');
        }

        if (!function_exists($functionName)) {
            throw new ControllerException('The functionName ('.$functionName.') is invalid.');
        }

        $this->name = $name;
        $this->pattern = $pattern;
        $this->view = $view;
        $this->functionName = $functionName;

    }

    public function getName(): string {
        return $this->name;
    }

    public function getPattern(): string {
        return $this->pattern;
    }

    public function getView(): View {
        return $this->view;
    }

    public function getFunction(): string {
        return $this->functionName;
    }

}
