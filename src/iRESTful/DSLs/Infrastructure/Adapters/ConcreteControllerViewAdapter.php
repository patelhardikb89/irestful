<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Adapters\ViewAdapter;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Templates\Adapters\TemplateAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerView;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Exceptions\ViewException;

final class ConcreteControllerViewAdapter implements ViewAdapter {
    private $templateAdapter;
    public function __construct(TemplateAdapter $templateAdapter) {
        $this->templateAdapter = $templateAdapter;
    }

    public function fromStringToView($string) {

        $string = strtolower($string);
        if ($string == 'json') {
            return new ConcreteControllerView(true);
        }

        throw new ViewException('The given string ('.$string.') does not point to a valid View.');
    }

    public function fromDataToView(array $data) {
        $template = $this->templateAdapter->fromDataToTemplate($data);
        return new ConcreteControllerView(false, $template);
    }

}
