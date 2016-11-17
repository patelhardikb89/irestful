<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\View;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Templates\Template;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerView implements View {
    private $isJson;
    private $template;
    public function __construct(bool $isJson, Template $template = null) {

        $amount = ($isJson ? 1 : 0) + (!empty($template) ? 1 : 0);
        if ($amount != 1) {
            throw new ViewException('There must be either a Template object, or the view must be json.  '.$amount.' provided.');
        }

        $this->isJson = (bool) $isJson;
        $this->template = $template;

    }

    public function isJson(): bool {
        return $this->isJson;
    }

    public function hasTemplate(): bool {
        return !empty($this->template);
    }

    public function getTemplate() {
        return $this->template;
    }

}
