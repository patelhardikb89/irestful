<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteControllerRuleCriteria;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\Exceptions\ControllerRuleCriteriaException;

final class ConcreteControllerRuleCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $uri;
    private $method;
    private $port;
    private $pattern;
    private $queryParameters;
    public function setUp() {
        $this->uri = '/my/uri';
        $this->method = 'get';
        $this->port = rand(1, 500);
        $this->pattern = '/[a-z]+/s';

        $this->queryParameters = [
            'my_property' => '/[a-z]+/s',
            'another' => 'strict',
            'just_another' => rand(1, 500),
            'just_just_another' => (float) (rand(1, 500) / 1000)
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreate_withEmptyPort_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method, '');

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreate_withPort_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method, $this->port);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertTrue($criteria->hasPort());
        $this->assertEquals($this->port, $criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreate_withQueryParameters_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method, null, $this->queryParameters);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertTrue($criteria->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $criteria->getQueryParameters());
    }

    public function testCreate_withMethod_withPort_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method, $this->port, $this->queryParameters);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertTrue($criteria->hasPort());
        $this->assertEquals($this->port, $criteria->getPort());
        $this->assertTrue($criteria->hasQueryParameters());
        $this->assertEquals($this->queryParameters, $criteria->getQueryParameters());
    }

    public function testCreate_uriIsPattern_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->pattern, $this->method);

        $this->assertEquals($this->pattern, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreate_methodIsPattern_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->pattern);

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->pattern, $criteria->getMethod());
        $this->assertFalse($criteria->hasPort());
        $this->assertNull($criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreatepostIsPattern_Success() {

        $criteria = new ConcreteControllerRuleCriteria($this->uri, $this->method, '/[0-9]+/s');

        $this->assertEquals($this->uri, $criteria->getUri());
        $this->assertEquals($this->method, $criteria->getMethod());
        $this->assertTrue($criteria->hasPort());
        $this->assertEquals('/[0-9]+/s', $criteria->getPort());
        $this->assertFalse($criteria->hasQueryParameters());
        $this->assertNull($criteria->getQueryParameters());
    }

    public function testCreate_withOneInvalidKeynameInQueryParameters_Success() {

        $this->queryParameters[0] = 'myvalue';

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria($this->uri, $this->method, $this->port, $this->queryParameters);

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withOneInvalidQueryParameters_Success() {

        $this->queryParameters['invalid'] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria($this->uri, $this->method, $this->port, $this->queryParameters);

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidPort_Success() {

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria($this->uri, $this->method, new \DateTime());

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptyMethod_Success() {

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria($this->uri, '');

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidMethod_Success() {

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria($this->uri, '');

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptyUri_Success() {

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria('', $this->method);

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withInvalidUri_Success() {

        $asserted = false;
        try {

            new ConcreteControllerRuleCriteria(new \DateTime(), $this->method);

        } catch (ControllerRuleCriteriaException $esxception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
