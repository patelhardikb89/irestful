<?php
namespace iRESTful\Rodson\Domain\Adapters;

interface RodsonAdapter {
    public function fromDataToRodson(array $data);
    public function fromDataToRodsons(array $data);
}
