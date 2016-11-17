<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Adapters\ControllerRuleAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Adapters\ControllerRuleCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteControllerRule;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Exceptions\ControllerRuleException;

final class ConcreteControllerRuleAdapter implements ControllerRuleAdapter {
    private $criteriaAdapter;
    public function __construct(ControllerRuleCriteriaAdapter $criteriaAdapter) {
        $this->criteriaAdapter = $criteriaAdapter;
    }

    public function fromDataToControllerRules(array $data) {

        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToControllerRule($oneData);
        }

        return $output;

    }

    public function fromDataToControllerRule(array $data) {

        if (!isset($data['controller'])) {
            throw new ControllerRuleException('The controller keyname is mandatory in order to convert data to a ControllerRule object.');
        }

        if (!isset($data['criteria'])) {
            throw new ControllerRuleException('The criteria keyname is mandatory in order to convert data to a ControllerRule object.');
        }

        if (!is_object($data['controller']) || (!($data['controller'] instanceof Controller))) {
            throw new ControllerRuleException('The controller keyname must contain a Controller object.');
        }

        if (!is_array($data['criteria'])) {
            throw new ControllerRuleException('The criteria must be an array.');
        }

        try {

            $criteria = $this->criteriaAdapter->fromDataToControllerRuleCriteria($data['criteria']);
            return new ConcreteControllerRule($criteria, $data['controller']);

        } catch (ControllerRuleCriteriaException $exception) {
            throw new ControllerRuleException('There was an exception while convertinf data to a ControllerRuleCriteria object.', $exception);
        }
    }

}
