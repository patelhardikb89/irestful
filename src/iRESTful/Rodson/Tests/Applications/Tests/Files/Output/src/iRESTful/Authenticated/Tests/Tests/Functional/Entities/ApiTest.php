<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class ApiTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();

        $data = [
                            json_decode('{
    "container": "api",
    "data": {
        "uuid": "10010456-29ab-401f-93bc-946cd3fd750a",
        "base_url": "http:\/\/apis.irestful.com",
        "endpoints": [
            {
                "uuid": "6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d",
                "is_user_mandatory": false,
                "pattern___regex_pattern": null,
                "pattern___specific_uri": "\/my\/value",
                "params": [
                    {
                        "uuid": "4d4ffc9b-03ee-4c7a-99bd-e7f9a83b5bc3",
                        "name": "my_second_param",
                        "pattern___regex_pattern": "[a-z0-9]+",
                        "pattern___specific_value": null,
                        "is_mandatory": true,
                        "created_on": 1470347043
                    },
                    {
                        "uuid": "cdf75f60-6c59-489c-a9eb-fc4080fed3ae",
                        "name": "my_param",
                        "pattern___regex_pattern": null,
                        "pattern___specific_value": "my value",
                        "is_mandatory": false,
                        "created_on": 1470347061
                    }
                ],
                "created_on": 1470347072
            }
        ],
        "created_on": 1470347090
    }
}', true),
                            json_decode('{
    "container": "api",
    "data": {
        "uuid": "10010456-29ab-401f-93bc-946cd3fd750a",
        "base_url": "http:\/\/test.irestful.com",
        "endpoints": null,
        "created_on": 1470347090
    }
}', true)
                    ];

        $this->helpers = [];
        foreach($data as $oneData) {
            $this->helpers[] = new ConversionHelper($this, $configs, $oneData);
        }
    }

    public function tearDown() {
        $this->helpers = null;
    }

            public function testConvert_Sample0_Success() {
            $this->helpers[0]->execute();
        }
            public function testConvert_Sample1_Success() {
            $this->helpers[1]->execute();
        }
    }
