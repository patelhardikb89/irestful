<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Applications\Factories\ApplicationFactory;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Applications\ConcreteApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\ConcreteHttpRequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteConfigurationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteControllerRuleAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteControllerRuleCriteriaAdapter;

final class ConcreteApplicationFactory implements ApplicationFactory {
    private $configs;
    public function __construct(array $configs) {
        $this->configs = $configs;
    }

    public function create() {

        $criteriaAdapter = new ConcreteControllerRuleCriteriaAdapter();
        $controllerRuleAdapter = new ConcreteControllerRuleAdapter($criteriaAdapter);
        $configurationAdapter = new ConcreteConfigurationAdapter($controllerRuleAdapter);
        $requestAdapter = new ConcreteHttpRequestAdapter();
        return new ConcreteApplication($this->configs, $requestAdapter, $configurationAdapter);
    }

}
