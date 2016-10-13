<?php
namespace iRESTful\Authenticated\Tests\Tests\Functional\Controllers;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRepositoryFactoryAdapter;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityServiceFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Adapters\ReflectionEntityAdapterAdapterFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\SDK\HttpEntities\Infrastructure\Adapters\HttpEntityRelationRepositoryFactoryAdapter;
use iRESTful\Objects\Entities\Entities\Infrastructure\Factories\ConcreteEntityAdapterFactory;

final class RetrieveSetTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

        $entityRepositoryFactoryAdapter = new HttpEntityRepositoryFactoryAdapter();
        $this->entityRepositoryFactory = $entityRepositoryFactoryAdapter->fromDataToEntityRepositoryFactory($params);

        $entityRelationRepositoryFactoryAdapter = new HttpEntityRelationRepositoryFactoryAdapter();
        $entityRelationRepository = $entityRelationRepositoryFactoryAdapter->fromDataToEntityRelationRepositoryFactory($params)->create();

        $entityServiceFactoryAdapter = new HttpEntityServiceFactoryAdapter();
        $this->entityServiceFactory = $entityServiceFactoryAdapter->fromDataToEntityServiceFactory($params);

        $entityAdapterAdapterFactoryAdapter = new ReflectionEntityAdapterAdapterFactoryAdapter();
        $entityAdapterAdapter = $entityAdapterAdapterFactoryAdapter->fromDataToEntityAdapterAdapterFactory($params)->create();
        $this->entityAdapterFactory = new ConcreteEntityAdapterFactory(
            $this->entityRepositoryFactory->create(),
            $entityRelationRepository,
            $entityAdapterAdapter
        );

        $this->init();
    }

    public function tearDown() {
        $this->entityRepositoryFactory = null;
        $this->entityServiceFactory = null;
        $this->entityAdapterFactory = null;
    }

                public function init() {
        $input = [
            [
                'container' => 'endpoint',
                'data' => [
                    'uuid' => '6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d',
                    'is_user_mandatory' => ,
                    'pattern___regex_pattern' => '',
                    'pattern___specific_uri' => '/my/value',
                    'params' => [
                        [
                            'uuid' => '4d4ffc9b-03ee-4c7a-99bd-e7f9a83b5bc3',
                            'name' => 'my_second_param',
                            'pattern___regex_pattern' => '[a-z0-9]+',
                            'pattern___specific_value' => '',
                            'is_mandatory' => 1,
                            'created_on' => 1470346899
                        ],
                        [
                            'uuid' => 'cdf75f60-6c59-489c-a9eb-fc4080fed3ae',
                            'name' => 'my_param',
                            'pattern___regex_pattern' => '',
                            'pattern___specific_value' => 'my value',
                            'is_mandatory' => ,
                            'created_on' => 1470346920
                        ]
                    ],
                    'created_on' => 1470346929
                ]
            ],
            [
                'container' => 'endpoint',
                'data' => [
                    'uuid' => '6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d',
                    'is_user_mandatory' => 1,
                    'pattern___regex_pattern' => '[.]+',
                    'pattern___specific_uri' => '',
                    'params' => '',
                    'created_on' => 1470346929
                ]
            ],
            [
                'container' => 'api',
                'data' => [
                    'uuid' => '10010456-29ab-401f-93bc-946cd3fd750a',
                    'base_url' => 'http://apis.irestful.com',
                    'endpoints' => [
                        [
                            'uuid' => '6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d',
                            'is_user_mandatory' => ,
                            'pattern___regex_pattern' => '',
                            'pattern___specific_uri' => '/my/value',
                            'params' => [
                                [
                                    'uuid' => '4d4ffc9b-03ee-4c7a-99bd-e7f9a83b5bc3',
                                    'name' => 'my_second_param',
                                    'pattern___regex_pattern' => '[a-z0-9]+',
                                    'pattern___specific_value' => '',
                                    'is_mandatory' => 1,
                                    'created_on' => 1470347043
                                ],
                                [
                                    'uuid' => 'cdf75f60-6c59-489c-a9eb-fc4080fed3ae',
                                    'name' => 'my_param',
                                    'pattern___regex_pattern' => '',
                                    'pattern___specific_value' => 'my value',
                                    'is_mandatory' => ,
                                    'created_on' => 1470347061
                                ]
                            ],
                            'created_on' => 1470347072
                        ]
                    ],
                    'created_on' => 1470347090
                ]
            ],
            [
                'container' => 'api',
                'data' => [
                    'uuid' => '10010456-29ab-401f-93bc-946cd3fd750a',
                    'base_url' => 'http://test.irestful.com',
                    'endpoints' => '',
                    'created_on' => 1470347090
                ]
            ],
            [
                'container' => 'params',
                'data' => [
                    'uuid' => '4d4ffc9b-03ee-4c7a-99bd-e7f9a83b5bc3',
                    'name' => 'my_second_param',
                    'pattern___regex_pattern' => '[a-z0-9]+',
                    'pattern___specific_value' => '',
                    'is_mandatory' => 1,
                    'created_on' => 1470347043
                ]
            ],
            [
                'container' => 'params',
                'data' => [
                    'uuid' => 'cdf75f60-6c59-489c-a9eb-fc4080fed3ae',
                    'name' => 'my_param',
                    'pattern___regex_pattern' => '',
                    'pattern___specific_value' => 'my value',
                    'is_mandatory' => ,
                    'created_on' => 1470347061
                ]
            ],
            [
                'container' => 'registration',
                'data' => [
                    'uuid' => '5b3ed235-5d8d-4702-9b92-532003e3bf96',
                    'keyname' => 'another_registration',
                    'title' => 'This is a another registration',
                    'description' => 'This is the description of the another registration',
                    'roles' => [
                        [
                            'uuid' => '6b7926c6-24df-4626-845c-4e6886231b81',
                            'title' => 'This is a second role',
                            'description' => 'This is a second role description.',
                            'permissions' => [
                                [
                                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                                    'title' => 'This is just a title',
                                    'description' => 'This is just a description',
                                    'can_read' => 1,
                                    'can_write' => ,
                                    'can_delete' => ,
                                    'created_on' => 1470347181
                                ]
                            ],
                            'created_on' => 1470347195
                        ]
                    ],
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'registration',
                'data' => [
                    'uuid' => '5b3ed235-5d8d-4702-9b92-532003e3bf96',
                    'keyname' => 'another_keyname',
                    'title' => 'This is a another keyname',
                    'description' => 'This is the description of the another keyname',
                    'roles' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'resource',
                'data' => [
                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                    'endpoint' => [
                        'uuid' => '6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d',
                        'is_user_mandatory' => ,
                        'pattern___regex_pattern' => '',
                        'pattern___specific_uri' => '/my/value',
                        'params' => '',
                        'created_on' => 1470346929
                    ],
                    'owner' => [
                        'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                        'software' => [
                            'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                            'name' => 'my_software_name',
                            'credentials___username' => 'my_software_username',
                            'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                            'credentials___password' => '',
                            'roles' => '',
                            'created_on' => 1470347205
                        ],
                        'user' => [
                            'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                            'name' => 'my_username',
                            'credentials___username' => 'my_user_username',
                            'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                            'credentials___password' => '',
                            'roles' => '',
                            'created_on' => 1470347205
                        ],
                        'created_on' => 1470347205
                    ],
                    'shared_resources' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'resource',
                'data' => [
                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                    'endpoint' => [
                        'uuid' => '6b7afaaf-b91f-4a1b-88a9-5d5ae8c2608d',
                        'is_user_mandatory' => 1,
                        'pattern___regex_pattern' => '[.]+',
                        'pattern___specific_uri' => '',
                        'params' => '',
                        'created_on' => 1470346929
                    ],
                    'owner' => [
                        'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                        'software' => [
                            'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                            'name' => 'my_software_name',
                            'credentials___username' => 'my_software_username',
                            'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                            'credentials___password' => '',
                            'roles' => '',
                            'created_on' => 1470347205
                        ],
                        'user' => [
                            'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                            'name' => 'my_username',
                            'credentials___username' => 'my_user_username',
                            'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                            'credentials___password' => '',
                            'roles' => '',
                            'created_on' => 1470347205
                        ],
                        'created_on' => 1470347205
                    ],
                    'shared_resources' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'shared_resource',
                'data' => [
                    'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                    'permissions' => '',
                    'owners' => [
                        [
                            'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                            'software' => [
                                'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                                'name' => 'my_software_name',
                                'credentials___username' => 'my_software_username',
                                'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                                'credentials___password' => '',
                                'roles' => '',
                                'created_on' => 1470347205
                            ],
                            'user' => [
                                'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                                'name' => 'my_username',
                                'credentials___username' => 'my_user_username',
                                'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                                'credentials___password' => '',
                                'roles' => '',
                                'created_on' => 1470347205
                            ],
                            'created_on' => 1470347205
                        ]
                    ],
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'shared_resource',
                'data' => [
                    'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                    'permissions' => [
                        [
                            'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                            'title' => 'This is just a title',
                            'description' => 'This is just a description',
                            'can_read' => 1,
                            'can_write' => ,
                            'can_delete' => ,
                            'created_on' => 1470347205
                        ]
                    ],
                    'owners' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'owner',
                'data' => [
                    'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                    'software' => [
                        'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                        'name' => 'my_software_name',
                        'credentials___username' => 'my_software_username',
                        'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                        'credentials___password' => '',
                        'roles' => '',
                        'created_on' => 1470347205
                    ],
                    'user' => [
                        'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                        'name' => 'my_username',
                        'credentials___username' => 'my_user_username',
                        'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                        'credentials___password' => '',
                        'roles' => '',
                        'created_on' => 1470347205
                    ],
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'owner',
                'data' => [
                    'uuid' => '416b1c6c-697d-4812-b900-43dd718f547d',
                    'software' => [
                        'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                        'name' => 'my_software_name',
                        'credentials___username' => 'my_software_username',
                        'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                        'credentials___password' => '',
                        'roles' => '',
                        'created_on' => 1470347205
                    ],
                    'user' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'software',
                'data' => [
                    'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                    'name' => 'my_software_name',
                    'credentials___username' => 'my_software_username',
                    'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                    'credentials___password' => '',
                    'roles' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'software',
                'data' => [
                    'uuid' => 'e21d4c75-8206-4996-a014-aa4ce6acf6b0',
                    'name' => 'another_software_name',
                    'credentials___username' => 'my_software_username',
                    'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                    'credentials___password' => '',
                    'roles' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'user',
                'data' => [
                    'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                    'name' => 'my_username',
                    'credentials___username' => 'my_user_username',
                    'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                    'credentials___password' => '',
                    'roles' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'user',
                'data' => [
                    'uuid' => 'b700c850-ca31-4023-9dc7-e0e2a9bcc256',
                    'name' => 'another_username',
                    'credentials___username' => 'my_user_username',
                    'credentials___hashed_password' => '$2y$10$x/U44x/ABmhuUJHgJqcXCOtzfCs6VRbuCHmVA56EfD/AAIyig9CmK',
                    'credentials___password' => '',
                    'roles' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'role',
                'data' => [
                    'uuid' => '2d7145b5-634d-4760-97fa-b2aaf283ad3b',
                    'title' => 'This is a role',
                    'description' => 'This is a role description.',
                    'permissions' => [
                        [
                            'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                            'title' => 'This is just a title',
                            'description' => 'This is just a description',
                            'can_read' => 1,
                            'can_write' => ,
                            'can_delete' => ,
                            'created_on' => 1470347205
                        ]
                    ],
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'role',
                'data' => [
                    'uuid' => '2d7145b5-634d-4760-97fa-b2aaf283ad3b',
                    'title' => 'This is an updated role',
                    'description' => 'This is an updated role description.',
                    'permissions' => '',
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'permission',
                'data' => [
                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                    'title' => 'This is just a title',
                    'description' => 'This is just a description',
                    'can_read' => 1,
                    'can_write' => ,
                    'can_delete' => ,
                    'created_on' => 1470347205
                ]
            ],
            [
                'container' => 'permission',
                'data' => [
                    'uuid' => '366ffc72-20cd-45a0-9d50-c2636010ea28',
                    'title' => 'This is just an updated title',
                    'description' => 'This is just an updated description',
                    'can_read' => ,
                    'can_write' => 1,
                    'can_delete' => 1,
                    'created_on' => 1470347212
                ]
            ]
        ];
        
        $samples = $this->entityAdapterFactory->create()->fromDataToEntities($input);
        
        $this->entityServiceFactory->create()->insert($samples);
        
        
        
        }

                    public function testExecute_0_Success() {
        $testFunctions = [
                function() {
                    $retrieveSetData = function($container, array $data, $index, $amount) {
                        $entities = $this->entitySetRepositoryFactory->create()->retrieve([
                            'container' => $containerName
                            'uuids' => 'uuid'
                        ]);
                        
                        $data = $this->entityAdapterFactory->create()->fromEntitiesToData($entities);
                        
                        return $data;
                        
                    }
                    
                    $amount = count($this->data);
                    foreach($this->data as $oneData) {
                        $sourceData = $retrieveSetData($oneData['container'], $oneData['data'], 0, $amount);
                        $this->assertEquals($oneData, $sourceData);
                    }
                }
        ];
        
        foreach($testFunctions as $oneTestFunction) {
            $oneTestFunction();
        }
        
        }

        
}
