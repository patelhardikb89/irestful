<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Adapters\SubEntitiesAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Subs\Exceptions\RequestSubEntitiesException;

final class SubEntitiesAdapterHelper {
    private $phpunit;
    private $subEntitiesAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntitiesAdapter $subEntitiesAdapterMock) {
        $this->phpunit = $phpunit;
        $this->subEntitiesAdapterMock = $subEntitiesAdapterMock;
    }

    public function expectsFromSubEntitiesToRequests_Success(array $returnedRequests, SubEntities $subEntities) {
        $this->subEntitiesAdapterMock->expects($this->phpunit->once())
                                        ->method('fromSubEntitiesToRequests')
                                        ->with($subEntities)
                                        ->will($this->phpunit->returnValue($returnedRequests));
    }

    public function expectsFromSubEntitiesToRequests_throwsRequestSubEntitiesException(SubEntities $subEntities) {
        $this->subEntitiesAdapterMock->expects($this->phpunit->once())
                                        ->method('fromSubEntitiesToRequests')
                                        ->with($subEntities)
                                        ->will($this->phpunit->throwException(new RequestSubEntitiesException('TEST')));
    }

}
