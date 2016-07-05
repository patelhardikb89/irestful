<?php
namespace iRESTful\Rodson\Tests\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\Adapters\RESTAPIAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\RESTAPI;
use iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\Exceptions\RESTAPIException;

final class RESTAPIAdapterHelper {
    private $phpunit;
    private $restAPIAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RESTAPIAdapter $restAPIAdapterMock) {
        $this->phpunit = $phpunit;
        $this->restAPIAdapterMock = $restAPIAdapterMock;
    }

    public function expectsFromDataToRESTAPI_Success(RESTAPI $returnedRESTAPI, array $data) {
        $this->restAPIAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToRESTAPI')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedRESTAPI));
    }

    public function expectsFromDataToRESTAPI_throwsRESTAPIException(array $data) {
        $this->restAPIAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToRESTAPI')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new RESTAPIException('TEST')));
    }

}
