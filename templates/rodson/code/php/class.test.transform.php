<?php
namespace {{namespace.path}};
use {{configuration.object_configuration.namespace.all}};
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class {{namespace.name}} extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new {{configuration.object_configuration.namespace.name}}();

        $data = [
            {% for oneSample in samples %}
                json_decode('{{- oneSample|json_encode(constant('JSON_PRETTY_PRINT'))|raw -}}', true){{loop.last ? '' : ','}}
            {% endfor %}
        ];

        $this->helpers = [];
        foreach($data as $oneData) {
            $this->helpers[] = new ConversionHelper($this, $configs, $oneData);
        }
    }

    public function tearDown() {
        $this->helpers = null;
    }

    {% for oneSample in samples %}
        public function testConvert_Sample{{loop.index0}}_Success() {
            $this->helpers[{{loop.index0}}]->execute();
        }
    {% endfor %}
}
