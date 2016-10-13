<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObjectSample;
use iRESTful\DSLs\Domain\Projects\Objects\Samples\Exceptions\SampleException;

final class ConcreteObjectSampleTest extends \PHPUnit_Framework_TestCase {
    private $data;
    public function setUp() {
        $this->data = [
            [
                'title' => 'This is a title',
                'sub' => [
                    'title' => 'This is a sub title',
                    'elements' => [
                        'first',
                        'second',
                        'third'
                    ]
                ]
            ]
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $sample = new ConcreteObjectSample($this->data);
        $this->assertEquals($this->data, $sample->getData());

    }

    public function testCreate_withObjectInData_throwsSampleException() {

        $data = [
            [
                'some' => new \DateTime()
            ]
        ];

        $asserted = false;
        try {

            new ConcreteObjectSample($data);

        } catch (SampleException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }
}
