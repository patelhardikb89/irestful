<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\ObjectMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\MetaDatas\Exceptions\ObjectMetaDataException;

final class ConcreteObjectMetaData implements ObjectMetaData {
	private $object;
	public function __construct($object) {

		if (!is_object($object)) {
			throw new ObjectMetaDataException('The object parameter must be an object.');
		}

		$this->object = $object;

	}

	public function getObject() {
		return $this->object;
	}

	public function call($methods) {

		$removeParenthesis = function($name) {
            return str_replace('()', '', $name);
        };

		$callMethodIfExists = function($object, $methodName) {

			if (!method_exists($object, $methodName)) {
				$className = get_class($object);
				throw new ObjectMetaDataException('The method name ('.$methodName.') does not exists on the object of class ('.$className.').');
			}

			return $object->$methodName();

		};

        if (strpos($methods, '->') !== false) {
			$object = $this->object;
            $exploded = explode('->', $methods);
            foreach($exploded as $oneMethodName) {

                $oneMethodName = $removeParenthesis($oneMethodName);
                if (empty($object)) {
                    return null;
                }

                if (!method_exists($object, $oneMethodName)) {
					$className = get_class($object);
					throw new ObjectMetaDataException('The method name ('.$oneMethodName.') does not exists on the object of class ('.$className.').');
                }

                $object = $callMethodIfExists($object, $oneMethodName);
            }

            return $object;
        }

        $methodName = $removeParenthesis($methods);
        return $callMethodIfExists($this->object, $methodName);

	}

}
