<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Adapters;

interface ControllerRuleCriteriaAdapter {
    public function fromDataToControllerRuleCriteria(array $data);
}
