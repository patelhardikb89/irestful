<?php
namespace iRESTful\Authenticated\Domain\Types\BaseUrls\Adapters;


interface BaseUrlAdapter {
    public function fromStringToBase_url($string);
}

