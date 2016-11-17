<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Adapters\ConcreteControllerRuleCriteriaAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;

final class ConcreteControllerRuleCriteriaAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uri;
    private $method;
    private $port;
    private $queryParameters;
    private $data;
    private $dataWithPort;
    private $dataWithQueryParameters;
    private $dataWithAll;
    private $adapter;
    public function setUp() {

        $this->uri = '/my/uri';
        $this->method = 'get';
        $this->port = rand(1, 500);
        $this->queryParameters = [
            'some' => 'params'
        ];

        $this->data = [
            'uri' => $this->uri,
            'method' => $this->method
        ];

        $this->dataWithPort = [
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port
        ];

        $this->dataWithQueryParameters = [
            'uri' => $this->uri,
            'method' => $this->method,
            'query_parameters' => $this->queryParameters
        ];

        $this->dataWithAll = [
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port,
            'query_parameters' => $this->queryParameters
        ];

        $this->adapter = new ConcreteControllerRuleCriteriaAdapter();

    }

    public function tearDown() {

    }

    public function testFromDataToControllerRuleCriteria_Success() {

        $criteria = $this->adapter->fromDataToControllerRuleCriteria($this->data);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());

    }

    public function testFromDataToControllerRuleCriteria_withPort_Success() {

        $criteria = $this->adapter->fromDataToControllerRuleCriteria($this->dataWithPort);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertTrue($criteria->hasPort());
        $this->assertEquals($this->port, $criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());

    }

    public function testFromDataToControllerRuleCriteria_withQueryParameters_Success() {

        $criteria = $this->adapter->fromDataToControllerRuleCriteria($this->dataWithQueryParameters);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertTrue($criteria->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $criteria->getQueryParameters());

    }

    public function testFromDataToControllerRuleCriteria_withPort_withQueryParameters_Success() {

        $criteria = $this->adapter->fromDataToControllerRuleCriteria($this->dataWithAll);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertTrue($criteria->hasPort());
        $this->assertEquals($this->port, $criteria->getPort());
        $this->assertTrue($criteria->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $criteria->getQueryParameters());

    }

    public function testFromDataToControllerRuleCriteria_withoutUri_throwsControllerRuleCriteriaException() {

        unset($this->data['uri']);

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRuleCriteria($this->data);

        } catch (ControllerRuleCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToControllerRuleCriteria_withoutMethod_throwsControllerRuleCriteriaException() {

        unset($this->data['method']);

        $asserted = false;
        try {

            $this->adapter->fromDataToControllerRuleCriteria($this->data);

        } catch (ControllerRuleCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
