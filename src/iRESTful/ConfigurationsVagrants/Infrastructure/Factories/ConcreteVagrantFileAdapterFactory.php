<?php
namespace iRESTful\ConfigurationsVagrants\Infrastructure\Factories;
use iRESTful\ConfigurationsVagrants\Domain\Adapters\Factories\VagrantFileAdapterFactory;
use iRESTful\ConfigurationsVagrants\Infrastructure\Adapters\ConcreteVagrantFileAdapter;

final class ConcreteVagrantFileAdapterFactory implements VagrantFileAdapterFactory {

    public function __construct() {

    }

    public function create() {
        return new ConcreteVagrantFileAdapter();
    }

}
