<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas;

interface ObjectMetaData {
	public function getObject();
	public function call($methods);
}
