<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;

final class MasterObject {
	private $title;
	private $second;
	public function __construct($title, SecondObject $second) {
		$this->title = $title;
		$this->second = $second;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getSecond() {
		return $this->second;
	}

    public function getLast() {
        return null;
    }

}
