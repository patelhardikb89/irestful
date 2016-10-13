<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Templates\Adapters\TemplateAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerViewTemplate;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Templates\Exceptions\TemplateException;

final class ConcreteControllerViewTemplateAdapter implements TemplateAdapter {

    public function __construct() {

    }

    public function fromDataToTemplate(array $data) {

        if (!isset($data['path'])) {
            throw new TemplateException('The path keyname is mandatory in order to convert data to a Template object.');
        }

        if (!isset($data['processor'])) {
            throw new TemplateException('The processor keyname is mandatory in order to convert data to a Template object.');
        }

        return new ConcreteControllerViewTemplate($data['path'], $data['processor']);

    }

}
