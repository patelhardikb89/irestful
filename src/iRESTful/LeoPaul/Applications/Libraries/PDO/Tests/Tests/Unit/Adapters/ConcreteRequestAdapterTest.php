<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcreteRequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects\RequestHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Exceptions\RequestException;

final class ConcreteRequestAdapterTest extends \PHPUnit_Framework_TestCase {
    private $requestMock;
    private $query;
    private $params;
    private $data;
    private $dataWithParams;
    private $adapter;
    private $requestHelper;
    public function setUp() {
        $this->requestMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request');
        $this->query = 'select * from my_table limit 0,1;';
        $this->params = [
            ':slug' => 'my_slug'
        ];

        $this->data = [
            'query' => $this->query
        ];

        $this->dataWithParams = [
            'query' => $this->query,
            'params' => $this->params
        ];

        $this->adapter = new ConcreteRequestAdapter();

        $this->requestHelper = new RequestHelper($this, $this->requestMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRequest_Success() {

        $request = $this->adapter->fromDataToRequest($this->data);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertFalse($request->hasParams());
        $this->assertNull($request->getParams());

    }

    public function testFromDataToRequest_withParamsInData_Success() {

        $request = $this->adapter->fromDataToRequest($this->dataWithParams);

        $this->assertEquals($this->query, $request->getQuery());
        $this->assertTrue($request->hasParams());
        $this->assertEquals($this->params, $request->getParams());

    }

    public function testFromDataToRequest_twice_Success() {

        $firstRequest = $this->adapter->fromDataToRequest($this->data);
        $secondRequest = $this->adapter->fromDataToRequest($this->data);

        $this->assertEquals($this->query, $firstRequest->getQuery());
        $this->assertFalse($firstRequest->hasParams());
        $this->assertNull($firstRequest->getParams());

        $this->assertEquals($this->query, $secondRequest->getQuery());
        $this->assertFalse($secondRequest->hasParams());
        $this->assertNull($secondRequest->getParams());

    }

    public function testFromDataToRequest_withoutQuery_throwsRequestException() {

        $asserted = false;
        try {

            unset($this->dataWithParams['query']);
            $this->adapter->fromDataToRequest($this->dataWithParams);

        } catch (RequestException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromRequestToData_Success() {

        $this->requestHelper->expectsGetQuery_Success($this->query);
        $this->requestHelper->expectsHasParams_Success(false);

        $data = $this->adapter->fromRequestToData($this->requestMock);

        $this->assertEquals($this->query, $data['query']);
        $this->assertFalse(isset($data['params']));

    }

    public function testFromRequestToData_withParams_Success() {

        $this->requestHelper->expectsGetQuery_Success($this->query);
        $this->requestHelper->expectsHasParams_Success(true);
        $this->requestHelper->expectsGetParams_Success($this->params);

        $data = $this->adapter->fromRequestToData($this->requestMock);

        $this->assertEquals($this->query, $data['query']);
        $this->assertTrue(isset($data['params']));
        $this->assertEquals($this->params, $data['params']);

    }

}
