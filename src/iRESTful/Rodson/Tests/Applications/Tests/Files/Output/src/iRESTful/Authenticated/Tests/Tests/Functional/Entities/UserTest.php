<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class UserTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();

        $data = [
                            json_decode('{
    "container": "user",
    "data": {
        "uuid": "b700c850-ca31-4023-9dc7-e0e2a9bcc256",
        "name": "my_username",
        "credentials___username": "my_user_username",
        "credentials___hashed_password": "$2y$10$x\/U44x\/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD\/AAIyig9CmK",
        "credentials___password": null,
        "roles": null,
        "created_on": 1470347205
    }
}', true),
                            json_decode('{
    "container": "user",
    "data": {
        "uuid": "b700c850-ca31-4023-9dc7-e0e2a9bcc256",
        "name": "another_username",
        "credentials___username": "my_user_username",
        "credentials___hashed_password": "$2y$10$x\/U44x\/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD\/AAIyig9CmK",
        "credentials___password": null,
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
