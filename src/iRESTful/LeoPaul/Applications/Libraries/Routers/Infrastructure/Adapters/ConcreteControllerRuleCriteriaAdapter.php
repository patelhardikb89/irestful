<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Adapters\ControllerRuleCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteControllerRuleCriteria;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;

final class ConcreteControllerRuleCriteriaAdapter implements ControllerRuleCriteriaAdapter {

    public function __construct() {

    }

    public function fromDataToControllerRuleCriteria(array $data) {

        if (!isset($data['uri'])) {
            throw new ControllerRuleCriteriaException('The uri keyname is mandatory in order to convert data to a ControllerRuleCriteria object.');
        }

        if (!isset($data['method'])) {
            throw new ControllerRuleCriteriaException('The method keyname is mandatory in order to convert data to a ControllerRuleCriteria object.');
        }

        $port = null;
        if (isset($data['port'])) {
            $port = $data['port'];
        }

        $queryParameters = null;
        if (isset($data['query_parameters'])) {
            $queryParameters = $data['query_parameters'];
        }

        return new ConcreteControllerRuleCriteria($data['uri'], $data['method'], $port, $queryParameters);

    }

}
