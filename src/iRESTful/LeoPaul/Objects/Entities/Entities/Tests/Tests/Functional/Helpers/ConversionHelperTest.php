<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Functional\Helpers;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteEntityConfiguration;
use iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\ConversionHelper;

final class ConversionHelperTest extends \PHPUnit_Framework_TestCase {
    private $helper;
    public function setUp() {

        $data = [
            'container' => 'simple_entity',
            'data' => [
                'uuid' => '2d1314a6-8f37-4260-8a46-3be294221df2',
                'title' => 'Some Title',
                'description' => 'Some Description',
                'slug' => 'simple-slug',
                'sub_entities' => [
                    [
                        'uuid' => 'd0acd39b-de8f-4daf-a651-55bc4c2a5dfc',
                        'title' => 'Second Title',
                        'description' => 'Second Description',
                        'slug' => 'second-simple-slug',
                        'sub_entities' => null,
                        'created_on' => time()
                    ]
                ],
                'created_on' => time()
            ]
        ];

        $configs = new ConcreteEntityConfiguration();
        $this->helper = new ConversionHelper($this, $configs, $data);

    }

    public function tearDown() {

    }

    public function testExecute_Success() {
        $this->helper->execute();
    }

}
