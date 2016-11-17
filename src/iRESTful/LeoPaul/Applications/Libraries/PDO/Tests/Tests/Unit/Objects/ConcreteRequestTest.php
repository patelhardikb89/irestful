<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcreteRequest;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequestTest extends \PHPUnit_Framework_TestCase {
    private $query;
    private $params;
    private $paramsWithSemiColons;
    public function setUp() {

        $this->query = 'insert into my_table (uuid, title) values(:uuid, :title);';

        $this->params = [
            'uuid' => hex2bin(str_replace('-', '', '51f8f15f-7c55-4894-bef8-c1f21551a862')),
            'title' => 'My Title'
        ];

        $this->paramsWithSemiColons = [
            ':uuid' => $this->params['uuid'],
            ':title' => $this->params['title'],
        ];

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $request = new ConcreteRequest($this->query);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertFalse($request->hasParams());
        $this->assertNull($request->getParams());
    }

    public function testCreate_withEmptyParams_Success() {

        $request = new ConcreteRequest($this->query, []);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertFalse($request->hasParams());
        $this->assertNull($request->getParams());
    }

    public function testCreate_withEmptyQuery_Success() {

        $asserted = false;
        try {

            new ConcreteRequest('');

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringQuery_Success() {

        $asserted = false;
        try {

            new ConcreteRequest(new \DateTime());

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withParams_Success() {

        $request = new ConcreteRequest($this->query, $this->params);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertTrue($request->hasParams());
        $this->assertEquals($this->paramsWithSemiColons, $request->getParams());
    }

    public function testCreate_withParamsWithSemiColons_Success() {

        $request = new ConcreteRequest($this->query, $this->paramsWithSemiColons);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertTrue($request->hasParams());
        $this->assertEquals($this->paramsWithSemiColons, $request->getParams());
    }

}
