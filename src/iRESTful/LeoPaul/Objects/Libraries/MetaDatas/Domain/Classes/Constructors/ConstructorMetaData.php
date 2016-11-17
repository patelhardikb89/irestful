<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors;

interface ConstructorMetaData {
	public function getArgumentMetaData();
	public function getMethodName();
	public function getKeyname();
    public function isKey();
    public function isUnique();
	public function hasHumanMethodName();
	public function getHumanMethodName();
	public function hasTransformer();
	public function getTransformer();
    public function hasDefault();
    public function getDefault();
    public function hasType();
    public function getType();
}
