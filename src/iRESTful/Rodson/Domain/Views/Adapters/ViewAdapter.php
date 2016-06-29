<?php
namespace iRESTful\Rodson\Domain\Views\Adapters;

interface ViewAdapter {
    public function fromDataToViews(array $data);
    public function fromDataToView(array $data);
}
