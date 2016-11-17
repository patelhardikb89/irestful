<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Adapters\ConfigurationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Configuration;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Exceptions\ConfigurationException;

final class ConfigurationAdapterHelper {
    private $phpunit;
    private $configurationAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, ConfigurationAdapter $configurationAdapterMock) {
        $this->phpunit = $phpunit;
        $this->configurationAdapterMock = $configurationAdapterMock;
    }

    public function expectsFromDataToConfiguration_Success(Configuration $returnedConfiguration, array $data) {
        $this->configurationAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToConfiguration')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedConfiguration));
    }

    public function expectsFromDataToConfiguration_throwsConfigurationException(array $data) {
        $this->configurationAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToConfiguration')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new ConfigurationException('TEST')));
    }

}
