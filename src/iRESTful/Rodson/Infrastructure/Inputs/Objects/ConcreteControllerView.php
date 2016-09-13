<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\View;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Templates\Template;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerView implements View {
    private $isJson;
    private $template;
    public function __construct($isJson, Template $template = null) {

        $amount = ($isJson ? 1 : 0) + (!empty($template) ? 1 : 0);
        if ($amount != 1) {
            throw new ViewException('There must be either a Template object, or the view must be json.  '.$amount.' provided.');
        }

        $this->isJson = (bool) $isJson;
        $this->template = $template;

    }

    public function isJson() {
        return $this->isJson;
    }

    public function hasTemplate() {
        return !empty($this->template);
    }

    public function getTemplate() {
        return $this->template;
    }

}
