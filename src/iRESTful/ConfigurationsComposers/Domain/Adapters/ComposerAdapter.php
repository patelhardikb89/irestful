<?php
namespace iRESTful\ConfigurationsComposers\Domain\Adapters;

interface ComposerAdapter {
    public function fromDataToComposer(array $data);
}
