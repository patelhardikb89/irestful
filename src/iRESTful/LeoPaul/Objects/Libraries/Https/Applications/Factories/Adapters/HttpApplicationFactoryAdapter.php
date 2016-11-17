<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\Adapters;

interface HttpApplicationFactoryAdapter {
    public function fromDataToHttpApplicationFactory(array $data);
}
