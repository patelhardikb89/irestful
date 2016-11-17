<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs;

interface Configuration {
    public function getControllerRules();
    public function hasNotFoundController();
    public function getNotFoundController();
}
