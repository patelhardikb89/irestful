<?php
namespace {{namespace.path}};
use {{installation.object_configuration.namespace.all}};
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Helpers\CRUDHelper;
use iRESTful\LeoPaul\Applications\APIs\Authenticated\Infrastructure\Configurations\AuthenticatedHttpConfiguration;

final class {{namespace.name}} extends \PHPUnit_Framework_TestCase {
    private $crudHelpers;
    public function setUp() {

        \{{installation.namespace.all}}::install();

        $allData = [
            {% for oneSample in samples %}
                json_decode('{{- oneSample|json_encode(constant('JSON_PRETTY_PRINT'))|raw -}}', true){{loop.last ? '' : ','}}
            {% endfor %}
        ];

        if (count($allData) < 2) {
            throw new \Exception('The CRUD tests must have at least 2 samples of data.');
        }

        $objectConfigurations = new {{installation.object_configuration.namespace.name}}();
        $params = [
            'transformer_objects' => $objectConfigurations->getTransformerObjects(),
            'container_class_mapper' => $objectConfigurations->getContainerClassMapper(),
            'interface_class_mapper' => $objectConfigurations->getInterfaceClassMapper(),
            'delimiter' => $objectConfigurations->getDelimiter(),
            'base_url' => getenv('API_PROTOCOL').'://'.getenv('API_DOMAIN'),
            'port' => getenv('API_PORT')
        ];

        $this->crudHelpers = [];
        foreach($allData as $index => $oneSample) {
            $nextIndex = $index + 1;
            $nextIndex = isset($allData[$nextIndex]) ? $nextIndex : 0;
            $allData[$nextIndex]['data']['uuid'] = $allData[$index]['data']['uuid']; //Quick hack: The updates will work only if both data have the same uuid.  Fix this in the CRUDHelper later.
            $this->crudHelpers[] = new CRUDHelper($this, $params, $allData[$index], $allData[$nextIndex]);
        }



    }

    public function tearDown() {
        \{{installation.namespace.all}}::install();
    }

    public function testRun_Success() {
        foreach($this->crudHelpers as $oneCrudHelper) {
            $oneCrudHelper->execute();
            $this->tearDown();
        }
    }

    public function testRunSet_Success() {
        foreach($this->crudHelpers as $oneCrudHelper) {
            $oneCrudHelper->executeSet();
            $this->tearDown();
        }
    }

}
