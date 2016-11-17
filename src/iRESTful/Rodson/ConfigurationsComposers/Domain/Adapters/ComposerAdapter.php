<?php
namespace iRESTful\Rodson\ConfigurationsComposers\Domain\Adapters;

interface ComposerAdapter {
    public function fromDataToComposer(array $data);
}
