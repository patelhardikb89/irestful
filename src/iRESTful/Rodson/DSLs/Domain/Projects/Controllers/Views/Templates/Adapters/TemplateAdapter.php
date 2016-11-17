<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Templates\Adapters;

interface TemplateAdapter {
    public function fromDataToTemplate(array $data);
}
