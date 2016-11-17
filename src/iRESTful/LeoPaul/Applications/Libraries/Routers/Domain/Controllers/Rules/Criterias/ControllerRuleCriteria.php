<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias;

interface ControllerRuleCriteria {
    public function getURI();
    public function getMethod();
    public function hasPort();
    public function getPort();
    public function hasQueryParameters();
    public function getQueryParameters();
}
