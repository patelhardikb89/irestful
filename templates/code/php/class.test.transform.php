<?php
namespace {{namespace.path}};
use {{configuration.namespace.all}};
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class {{namespace.name}} extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new {{namespace.name}};

        $this->data = [
            {% for oneSample in samples %}
                [json_decode('{{- oneSample|json_encode(constant('JSON_PRETTY_PRINT'))|raw -}}', true)]{{loop.last ? '' : ','}}
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
        public function testConvert_sample{{loop.index}}_Success() {
            $this->helpers[{{loop.index}}]->execute();
        }
    {% endfor %}
}
