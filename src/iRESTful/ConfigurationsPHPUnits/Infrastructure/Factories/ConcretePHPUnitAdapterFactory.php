<?php
namespace iRESTful\ConfigurationsPHPUnits\Infrastructure\Factories;
use iRESTful\ConfigurationsPHPUnits\Domain\Adapters\Factories\PHPUnitAdapterFactory;
use iRESTful\ConfigurationsPHPUnits\Infrastructure\Adapters\ConcretePHPUnitAdapter;

final class ConcretePHPUnitAdapterFactory implements PHPUnitAdapterFactory {

    public function __construct() {

    }

    public function create() {
        return new ConcretePHPUnitAdapter();
    }

}
