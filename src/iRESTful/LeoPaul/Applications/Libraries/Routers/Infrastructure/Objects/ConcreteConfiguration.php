<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Configuration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Exceptions\ConfigurationException;

final class ConcreteConfiguration implements Configuration {
    private $rules;
    private $controller;
    public function __construct(array $rules, Controller $controller = null) {

        foreach($rules as $oneRule) {
            if (!($oneRule instanceof \iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule)) {
                throw new ConfigurationException('The rules array must only contain ControllerRule objects.');
            }
        }

        $this->rules = $rules;
        $this->controller = $controller;
    }

    public function getControllerRules() {
        return $this->rules;
    }

    public function hasNotFoundController() {
        return !empty($this->controller);
    }

    public function getNotFoundController() {
        return $this->controller;
    }

}
