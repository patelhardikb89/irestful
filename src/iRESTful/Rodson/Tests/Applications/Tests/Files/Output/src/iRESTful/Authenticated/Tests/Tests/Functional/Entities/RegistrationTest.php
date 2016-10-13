<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class RegistrationTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();

        $data = [
                            json_decode('{
    "container": "registration",
    "data": {
        "uuid": "5b3ed235-5d8d-4702-9b92-532003e3bf96",
        "keyname": "another_registration",
        "title": "This is a another registration",
        "description": "This is the description of the another registration",
        "roles": [
            {
                "uuid": "6b7926c6-24df-4626-845c-4e6886231b81",
                "title": "This is a second role",
                "description": "This is a second role description.",
                "permissions": [
                    {
                        "uuid": "366ffc72-20cd-45a0-9d50-c2636010ea28",
                        "title": "This is just a title",
                        "description": "This is just a description",
                        "can_read": true,
                        "can_write": false,
                        "can_delete": false,
                        "created_on": 1470347181
                    }
                ],
                "created_on": 1470347195
            }
        ],
        "created_on": 1470347205
    }
}', true),
                            json_decode('{
    "container": "registration",
    "data": {
        "uuid": "5b3ed235-5d8d-4702-9b92-532003e3bf96",
        "keyname": "another_keyname",
        "title": "This is a another keyname",
        "description": "This is the description of the another keyname",
        "roles": null,
        "created_on": 1470347205
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
