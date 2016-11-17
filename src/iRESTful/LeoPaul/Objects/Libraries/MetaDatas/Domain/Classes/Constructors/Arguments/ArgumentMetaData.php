<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments;

interface ArgumentMetaData {
	public function getName();
	public function getPosition();
	public function isOptional();
	public function	isRecursive();
	public function hasClassMetaData();
	public function getClassMetaData();
	public function hasArrayMetaData();
	public function getArrayMetaData();
}
