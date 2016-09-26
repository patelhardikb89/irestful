<?php
namespace iRESTful\Rodson\Domain\Middles\Composers\Adapters;

interface ComposerAdapter {
    public function fromDataToComposer(array $data);
}
