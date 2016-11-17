<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;

final class ThirdObject {
	private $title;
	public function __construct($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

}
