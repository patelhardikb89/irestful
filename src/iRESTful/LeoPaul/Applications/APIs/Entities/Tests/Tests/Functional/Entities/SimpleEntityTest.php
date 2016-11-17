<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Functional\Entities;
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Helpers\CRUDHelper;
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations\ConcreteEntityHttpConfiguration;
use iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ConcreteEntityObjectsConfiguration;

final class SimpleEntityTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {

        \iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Installations\Database::install();

        $data = [
            'container' => 'simple_entity',
            'data' => [
                'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                'slug' => 'this-is-a-simple-slug',
                'title' => 'This is the first title',
                'description' => 'This is just the first description.  Hurray!',
                'created_on' => time() - 20
            ]
        ];

        $updatedData = [
            'container' => 'simple_entity',
            'data' => [
                'uuid' => '65d42fab-bd6d-4048-ae70-0cff51defa15',
                'slug' => 'this-is-an-updated-first-slug',
                'title' => 'This is an updated first title.',
                'description' => 'This is an updated first description!',
                'created_on' => time() - 30
            ]
        ];

        $keyname = [
            'name' => 'slug',
            'value' => $data['data']['slug']
        ];

        $keynames = [
            'slug' => $data['data']['slug'],
            'created_on' => $data['data']['created_on']
        ];

        $configs = new ConcreteEntityHttpConfiguration(getenv('API_PROTOCOL'), getenv('ENTITIES_API_URL'), new ConcreteEntityObjectsConfiguration());
        $this->crudHelper = new CRUDHelper(
            $this,
            $configs->get(),
            $data,
            $updatedData,
            $keyname,
            $keynames
        );

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
