<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Entities;
use iRESTful\Authenticated\Infrastructure\Configurations\AuthenticatedConfiguration;
use iRESTful\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class RegistrationTest extends \PHPUnit_Framework_TestCase {
    private $helpers;
    public function setUp() {
        $configs = new AuthenticatedConfiguration();
        $data = [
            [
                'container' => 'registration',
                'data' => [
                    'uuid' => '5b3ed235-5d8d-4702-9b92-532003e3bf96',
                    'keyname' => 'another_registration',
                    'title' => 'This is a another registration',
                    'description' => 'This is the description of the another registration',
                    'roles' => [
                        0 => [
                            'uuid' => '6b7926c6-24df-4626-845c-4e6886231b81',
                            'title' => 'This is a second role',
                            'description' => 'This is a second role description.',
                            'permissions' => [
                                0 => [
                                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                                    'title' => 'This is just a title',
                                    'description' => 'This is just a description',
                                    'can_read' => '1',
                                    'can_write' => '',
                                    'can_delete' => '',
                                    'created_on' => 1470347181
                                ]
                            ],
                            'created_on' => 1470347195
                        ]
                    ],
                    'created_on' => 1470347205
                ]
            ]
        ];
        
        $this->helpers = [];
        foreach($data as $oneData) {
            $this->helpers[] = new ConversionHelper($this, $configs, $oneData);
        }
    }
    
    public function tearDown() {
        $this->helpers = null;
    }

    public function testConvert0_Success() {
        $this->helpers[0]->execute();
    }
    
}
