<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Adapters;

interface ControllerRuleAdapter {
    public function fromDataToControllerRule(array $data);
    public function fromDataToControllerRules(array $data);
}
