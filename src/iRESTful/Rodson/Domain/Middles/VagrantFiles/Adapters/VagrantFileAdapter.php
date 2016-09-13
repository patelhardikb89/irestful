<?php
namespace iRESTful\Rodson\Domain\Middles\VagrantFiles\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface VagrantFileAdapter {
    public function fromRodsonToVagrantFile(Rodson $rodson);
}
