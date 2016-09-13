<?php
namespace iRESTful\Rodson\Domain\Middles\Composers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Rodson;

interface ComposerAdapter {
    public function fromRodsonToComposer(Rodson $rodson);
}
