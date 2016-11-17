<?php
namespace iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Factories;
use iRESTful\Rodson\ConfigurationsPHPUnits\Domain\Adapters\Factories\PHPUnitAdapterFactory;
use iRESTful\Rodson\ConfigurationsPHPUnits\Infrastructure\Adapters\ConcretePHPUnitAdapter;

final class ConcretePHPUnitAdapterFactory implements PHPUnitAdapterFactory {

    public function __construct() {

    }

    public function create() {
        return new ConcretePHPUnitAdapter();
    }

}
