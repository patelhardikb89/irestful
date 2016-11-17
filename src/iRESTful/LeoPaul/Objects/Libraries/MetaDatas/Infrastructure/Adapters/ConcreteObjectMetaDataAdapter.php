<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\Adapters\ObjectMetaDataAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteObjectMetaData;

final class ConcreteObjectMetaDataAdapter implements ObjectMetaDataAdapter {

	public function __construct() {

	}

	public function fromObjectToObjectMetaData($object) {
		return new ConcreteObjectMetaData($object);
	}

}
