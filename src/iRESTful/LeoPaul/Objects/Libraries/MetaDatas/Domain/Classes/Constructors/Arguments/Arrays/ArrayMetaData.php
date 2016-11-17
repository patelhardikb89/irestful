<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays;

interface ArrayMetaData {
	public function hasElementsType();
	public function getElementsType();
    public function hasTransformers();
    public function getToObjectTransformer();
    public function getToDataTransformer();
}
