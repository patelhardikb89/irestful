<?php
namespace iRESTful\Rodson\Domain\Inputs\Adapters\Factories\Adapters;

interface RodsonAdapterFactoryAdapter {
    public function fromDataToRodsonAdapterFactory(array $data);
}
