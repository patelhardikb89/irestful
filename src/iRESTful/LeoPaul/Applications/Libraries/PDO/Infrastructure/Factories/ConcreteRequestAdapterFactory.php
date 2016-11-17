<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Adapters\Factories\RequestAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteRequestAdapter;

final class ConcreteRequestAdapterFactory implements RequestAdapterFactory {

    public function __construct() {

    }

    public function create() {
        return new ConcreteRequestAdapter();
    }

}
