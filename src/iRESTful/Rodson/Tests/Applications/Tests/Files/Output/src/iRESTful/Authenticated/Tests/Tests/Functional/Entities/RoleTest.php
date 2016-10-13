<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class RoleTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();

        $data = [
                            json_decode('{
    "container": "role",
    "data": {
        "uuid": "2d7145b5-634d-4760-97fa-b2aaf283ad3b",
        "title": "This is a role",
        "description": "This is a role description.",
        "permissions": [
            {
                "uuid": "366ffc72-20cd-45a0-9d50-c2636010ea28",
                "title": "This is just a title",
                "description": "This is just a description",
                "can_read": true,
                "can_write": false,
                "can_delete": false,
                "created_on": 1470347205
            }
        ],
        "created_on": 1470347205
    }
}', true),
                            json_decode('{
    "container": "role",
    "data": {
        "uuid": "2d7145b5-634d-4760-97fa-b2aaf283ad3b",
        "title": "This is an updated role",
        "description": "This is an updated role description.",
        "permissions": null,
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
