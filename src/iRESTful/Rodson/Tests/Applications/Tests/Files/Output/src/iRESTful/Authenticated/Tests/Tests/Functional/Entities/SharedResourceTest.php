<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class SharedResourceTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();

        $data = [
                            json_decode('{
    "container": "shared_resource",
    "data": {
        "uuid": "416b1c6c-697d-4812-b900-43dd718f547d",
        "permissions": null,
        "owners": [
            {
                "uuid": "416b1c6c-697d-4812-b900-43dd718f547d",
                "software": {
                    "uuid": "e21d4c75-8206-4996-a014-aa4ce6acf6b0",
                    "name": "my_software_name",
                    "credentials___username": "my_software_username",
                    "credentials___hashed_password": "$2y$10$x\/U44x\/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD\/AAIyig9CmK",
                    "credentials___password": null,
                    "roles": null,
                    "created_on": 1470347205
                },
                "user": {
                    "uuid": "b700c850-ca31-4023-9dc7-e0e2a9bcc256",
                    "name": "my_username",
                    "credentials___username": "my_user_username",
                    "credentials___hashed_password": "$2y$10$x\/U44x\/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD\/AAIyig9CmK",
                    "credentials___password": null,
                    "roles": null,
                    "created_on": 1470347205
                },
                "created_on": 1470347205
            }
        ],
        "created_on": 1470347205
    }
}', true),
                            json_decode('{
    "container": "shared_resource",
    "data": {
        "uuid": "416b1c6c-697d-4812-b900-43dd718f547d",
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
        "owners": null,
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
