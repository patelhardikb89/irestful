<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Tests\Helpers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

final class UuidClass {
	private static $isThrowing = false;
	public static function willThrowException() {
		self::$isThrowing = true;
	}

	public static function uuid4() {

		if (self::$isThrowing) {
			throw new UnsatisfiedDependencyException('TEST');
		}

		return Uuid::uuid4();
	}
}
