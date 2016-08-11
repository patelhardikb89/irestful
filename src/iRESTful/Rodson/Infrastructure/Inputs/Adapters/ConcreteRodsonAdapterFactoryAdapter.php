<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\Factories\Adapters\RodsonAdapterFactoryAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcreteRodsonAdapterFactory;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;

final class ConcreteRodsonAdapterFactoryAdapter implements RodsonAdapterFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToRodsonAdapterFactory(array $data) {

        if (!isset($data['code']) || !is_array($data['code'])) {
            throw new RodsonException('The code keyname is mandatory in order to convert data to a RodsonAdapterFactory object.');
        }

        if (!isset($data['adapters']) || !is_array($data['adapters'])) {
            throw new RodsonException('The adapters keyname is mandatory in order to convert data to a RodsonAdapterFactory object.');
        }

        if (!isset($data['databases']) || !is_array($data['databases'])) {
            throw new RodsonException('The databases keyname is mandatory in order to convert data to a RodsonAdapterFactory object.');
        }

        if (!isset($data['types']) || !is_array($data['types'])) {
            throw new RodsonException('The types keyname is mandatory in order to convert data to a RodsonAdapterFactory object.');
        }

        if (!isset($data['objects']) || !is_array($data['objects'])) {
            throw new RodsonException('The objects keyname is mandatory in order to convert data to a RodsonAdapterFactory object.');
        }

        return new ConcreteRodsonAdapterFactory($data['code'], $data['adapters'], $data['databases'], $data['types'], $data['objects']);

    }

}
