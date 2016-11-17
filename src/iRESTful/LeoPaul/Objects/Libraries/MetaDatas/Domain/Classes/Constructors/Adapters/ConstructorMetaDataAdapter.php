<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Adapters;

interface ConstructorMetaDataAdapter {
	public function fromDataToConstructorMetaDatas(array $data);
	public function fromDataToConstructorMetaData(array $data);
}
