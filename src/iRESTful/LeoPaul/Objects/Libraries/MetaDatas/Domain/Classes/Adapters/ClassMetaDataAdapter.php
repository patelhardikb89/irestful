<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Adapters;

interface ClassMetaDataAdapter {
	public function fromDataToClassMetaData(array $data);
}
