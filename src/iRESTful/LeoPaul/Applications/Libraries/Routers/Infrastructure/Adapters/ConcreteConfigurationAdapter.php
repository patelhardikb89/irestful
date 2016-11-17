<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Adapters\ConfigurationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Adapters\ControllerRuleAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteConfiguration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Exceptions\ConfigurationException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Exceptions\ControllerRuleException;

final class ConcreteConfigurationAdapter implements ConfigurationAdapter {
    private $controllerRuleAdapter;
    public function __construct(ControllerRuleAdapter $controllerRuleAdapter) {
        $this->controllerRuleAdapter = $controllerRuleAdapter;
    }

    public function fromDataToConfiguration(array $data) {

        if (isset($data['rules']) && !is_array($data['rules'])) {
            throw new ConfigurationException('The rules keyname must be an array.');
        }

        if (isset($data['not_found']) && (!($data['not_found'] instanceof Controller))) {
            throw new ConfigurationException('The not_found keyname must contain the Controller object, executed when no other Controller can be executed.');
        }

        try {

            $rules = [];
            if (isset($data['rules'])) {
                $rules = $this->controllerRuleAdapter->fromDataToControllerRules($data['rules']);
            }

            $notFoundController = null;
            if (isset($data['not_found'])) {
                $notFoundController = $data['not_found'];
            }

            return new ConcreteConfiguration($rules, $notFoundController);

        } catch (ControllerRuleException $exception) {
            throw new ConfigurationException('There was an exception while converting data to ControllerRule objects.', $exception);
        }

    }

}
