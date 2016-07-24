<?php
namespace iRESTful\Rodson\Domain\Inputs\Adapters;

interface RodsonAdapter {
    public function fromDataToRodson(array $data);
    public function fromDataToRodsons(array $data);
}
