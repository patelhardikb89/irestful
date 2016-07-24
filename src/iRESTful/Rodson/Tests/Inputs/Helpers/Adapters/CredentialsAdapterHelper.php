<?php
namespace iRESTful\Rodson\Tests\Inputs\Helpers\Adapters;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters\CredentialsAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Credentials;
use iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Exceptions\CredentialsException;

final class CredentialsAdapterHelper {
    private $phpunit;
    private $credentialsAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, CredentialsAdapter $credentialsAdapterMock) {
        $this->phpunit = $phpunit;
        $this->credentialsAdapterMock = $credentialsAdapterMock;
    }

    public function expectsFromDataToCredentials_Success(Credentials $returnedCredentials, array $data) {
        $this->credentialsAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToCredentials')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedCredentials));
    }

    public function expectsFromDataToCredentials_throwsCredentialsException(array $data) {
        $this->credentialsAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToCredentials')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new CredentialsException('TEST')));
    }

}
