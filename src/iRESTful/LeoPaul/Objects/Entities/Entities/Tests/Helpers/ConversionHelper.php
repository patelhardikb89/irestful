<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Configurations\EntityConfiguration;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionObjectAdapterFactory;

final class ConversionHelper {
    private $phpunit;
    private $objectAdapter;
    private $data;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityConfiguration $configs, array $data) {
        $this->phpunit = $phpunit;
        $objectAdapterFactory = new ReflectionObjectAdapterFactory(
            $configs->getTransformerObjects(),
            $configs->getContainerClassMapper(),
            $configs->getInterfaceClassMapper(),
            $configs->getDelimiter()
        );

        $this->objectAdapter = $objectAdapterFactory->create();
        $this->data = $data;
    }

    public function execute() {
        $object = $this->objectAdapter->fromDataToObject($this->data);
        $data = $this->objectAdapter->fromObjectToData($object, true);

        $this->phpunit->assertEquals($this->data['data'], $data);
    }

}
