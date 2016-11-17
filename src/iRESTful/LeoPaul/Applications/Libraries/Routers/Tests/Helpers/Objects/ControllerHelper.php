<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\AuthenticateException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\AuthorizationException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidDataException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidMediaException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;

final class ControllerHelper {
    private $phpunit;
    private $controllerMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Controller $controllerMock) {
        $this->phpunit = $phpunit;
        $this->controllerMock = $controllerMock;
    }

    public function expectsExecute_Success(ControllerResponse $returnedResponse, HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->returnValue($returnedResponse));
    }

    public function expectsExecute_throwsAuthenticateException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new AuthenticateException('TEST')));
    }

    public function expectsExecute_throwsAuthorizationException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new AuthorizationException('TEST')));
    }

    public function expectsExecute_throwsInvalidDataException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new InvalidDataException('TEST')));
    }

    public function expectsExecute_throwsInvalidMediaException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new InvalidMediaException('TEST')));
    }

    public function expectsExecute_throwsNotFoundException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new NotFoundException('TEST')));
    }

    public function expectsExecute_throwsServerException(HttpRequest $request) {
        $this->controllerMock->expects($this->phpunit->once())
                                ->method('execute')
                                ->with($request)
                                ->will($this->phpunit->throwException(new ServerException('TEST')));
    }

}
