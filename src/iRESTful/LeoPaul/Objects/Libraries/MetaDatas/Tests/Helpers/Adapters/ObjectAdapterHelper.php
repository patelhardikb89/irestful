<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;

final class ObjectAdapterHelper {
	private $phpunit;
	private $objectAdapterMock;
	public function __construct(\PHPUnit_Framework_TestCase $phpunit, ObjectAdapter $objectAdapterMock) {
		$this->phpunit = $phpunit;
		$this->objectAdapterMock = $objectAdapterMock;
	}

	public function expectsFromObjectToData_Success(array $returnedData, $object, $isHumanReadable) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToData')
									->with($object, $isHumanReadable)
									->will($this->phpunit->returnValue($returnedData));
	}

	public function expectsFromObjectToData_throwsObjectException($object, $isHumanReadable) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToData')
									->with($object, $isHumanReadable)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
	}

	public function expectsFromDataToObject_Success($returnedObject, array $data) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromDataToObject')
									->with($data)
									->will($this->phpunit->returnValue($returnedObject));
	}

	public function expectsFromDataToObject_throwsObjectException(array $data) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromDataToObject')
									->with($data)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
	}

	public function expectsFromDataToObjects_Success(array $returnedObjects, array $data) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromDataToObjects')
									->with($data)
									->will($this->phpunit->returnValue($returnedObjects));
	}

	public function expectsFromDataToObjects_throwsObjectException(array $data) {
		$this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromDataToObjects')
									->with($data)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
	}

    public function expectsFromObjectToSubObjects_Success(array $returnedObjects, $object) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToSubObjects')
									->with($object)
									->will($this->phpunit->returnValue($returnedObjects));
    }

    public function expectsFromObjectToSubObjects_throwsObjectException($object) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToSubObjects')
									->with($object)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

    public function expectsFromObjectsToSubObjects_Success(array $returnedObjects, array $objects) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectsToSubObjects')
									->with($objects)
									->will($this->phpunit->returnValue($returnedObjects));
    }

    public function expectsFromObjectsToSubObjects_throwsObjectException(array $objects) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectsToSubObjects')
									->with($objects)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

    public function expectsFromObjectToRelationObjects_Success(array $returnedRelationObjects, $object) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToRelationObjects')
									->with($object)
									->will($this->phpunit->returnValue($returnedRelationObjects));
    }

    public function expectsFromObjectToRelationObjects_throwsObjectException($object) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectToRelationObjects')
									->with($object)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

    public function expectsFromObjectsToRelationObjectsList_Success(array $returnedRelationObjects, array $objects) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectsToRelationObjectsList')
									->with($objects)
									->will($this->phpunit->returnValue($returnedRelationObjects));
    }

    public function expectsFromObjectsToRelationObjectsList_throwsObjectException(array $objects) {
        $this->objectAdapterMock->expects($this->phpunit->once())
									->method('fromObjectsToRelationObjectsList')
									->with($objects)
									->will($this->phpunit->throwException(new ObjectException('TEST')));
    }

}
