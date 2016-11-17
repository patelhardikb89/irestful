<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Functional\Entities;
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Helpers\CRUDHelper;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations\ConcreteEntityHttpConfiguration;
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ConcreteEntityObjectsConfiguration;

final class ComplexEntityWithoutSimpleEntitiesThenWithTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

        \iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Installations\Database::install();

        $firstData = [
            'container' => 'complex_entity',
            'data' => [
                'uuid' => 'f9f63b88-889c-43b1-9cef-8acb26b910a7',
                'slug' => 'this-is-a-complex-slug',
                'name' => 'ComplexEntity first title',
                'description' => 'Complex entity first description.  Oh yeah!',
                'simple_entity' => [
                    'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                    'slug' => 'this-is-a-simple-slug',
                    'title' => 'This is the first title',
                    'description' => 'This is just the first description.  Hurray!',
                    'created_on' => time() - 20

                ],
                'simple_entities' => null,
                'created_on' => time() - 20
            ]
        ];

        $updatedFirstData = [
            'container' => 'complex_entity',
            'data' => [
                'uuid' => 'f9f63b88-889c-43b1-9cef-8acb26b910a7',
                'slug' => 'updated-this-is-an-updated-first-slug',
                'name' => 'Updated - This is an updated first title.',
                'description' => 'Updated - This is an updated first description!',
                'simple_entity' => [
                    'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                    'slug' => 'updated-this-is-a-simple-slug',
                    'title' => 'Updated - This is the first title',
                    'description' => 'Updated - This is just the first description.  Hurray!',
                    'created_on' => time() - 20
                ],
                'simple_entities' => [
                    [
                        'uuid' => 'a9672885-6038-439c-857e-b018768f1ecd',
                        'slug' => 'sub-simple-entity-slug',
                        'title' => 'First sub simple entity.',
                        'description' => 'First sub simple entity description.',
                        'created_on' => time() - 30
                    ],
                    [
                        'uuid' => 'aa21f472-dcb1-474e-9535-9fa11ca5e257',
                        'slug' => 'sub-simple-entity-slug-second',
                        'title' => 'Second sub simple entity.',
                        'description' => 'Second sub simple entity description.',
                        'created_on' => time() - 30
                    ]
                ],
                'created_on' => time() - 30
            ]

        ];

        $configs = new ConcreteEntityHttpConfiguration(getenv('API_PROTOCOL'), getenv('ENTITIES_API_URL'), new ConcreteEntityObjectsConfiguration());
        $this->crudHelper = new CRUDHelper($this, $configs->get(), $firstData, $updatedFirstData);

    }

    public function tearDown() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();
    }

    public function testRun_Success() {
        $this->crudHelper->execute();
    }

    public function testRunSet_Success() {
        $this->crudHelper->executeSet();
    }

}
