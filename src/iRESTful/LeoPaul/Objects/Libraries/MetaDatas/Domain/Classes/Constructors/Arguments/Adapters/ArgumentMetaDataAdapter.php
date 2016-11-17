<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Adapters;

interface ArgumentMetaDataAdapter {
	public function fromDataToArgumentMetaData(array $data);
}
