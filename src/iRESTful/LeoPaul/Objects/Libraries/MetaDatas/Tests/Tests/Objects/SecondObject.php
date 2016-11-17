<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;

final class SecondObject {
	private $title;
	private $third;
	public function __construct($title, ThirdObject $third) {
		$this->title = $title;
		$this->third = $third;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getThird() {
		return $this->third;
	}

}
