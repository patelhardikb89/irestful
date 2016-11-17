<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes;

interface ClassMetaData {
	public function getType();
	public function getArguments();
	public function hasContainerName();
	public function getContainerName();
}
