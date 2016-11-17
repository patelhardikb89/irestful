<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects\ConcreteControllerRule;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects\ControllerRuleCriteriaHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;

final class ConcreteControllerRuleTest extends \PHPUnit_Framework_TestCase {
    private $controllerRuleCriteriaMock;
    private $controllerMock;
    private $httpRequestMock;
    private $uri;
    private $method;
    private $port;
    private $queryParameters;
    private $uriPattern;
    private $methodPattern;
    private $portPattern;
    private $queryParamPatterns;
    private $rule;
    private $controllerRuleCriteriaHelper;
    private $httpRequestHelper;
    public function setUp() {
        $this->controllerRuleCriteriaMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria');
        $this->controllerMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');

        $this->uri = '/my/87';
        $this->method = 'get';
        $this->port = rand(1, 500);
        $this->queryParameters = [
            'some' => 'param'
        ];

        $this->uriPattern = '\/[a-z]+\/[0-9]+';
        $this->methodPattern = '[a-z]+';
        $this->portPattern = '[0-9]+';
        $this->queryParamPatterns = [
            'some' => '[a-z]+'
        ];

        $this->rule = new ConcreteControllerRule($this->controllerRuleCriteriaMock, $this->controllerMock);

        $this->controllerRuleCriteriaHelper = new ControllerRuleCriteriaHelper($this, $this->controllerRuleCriteriaMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
    }

    public function tearDown() {

    }

    public function testGetController_Success() {

        $this->assertEquals($this->controllerMock, $this->rule->getController());

    }

    public function testMatch_uriDoesNotMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success('/not/the/same');
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, '/not/the/same');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriDoesNotMatch_withPattern_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success('/[0-9]+/s');
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, '/[0-9]+/s');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPerfectMatch_methodDoesNotMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uri);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uri);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success('post');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPerfectMatch_methodDoesNotMatch_methodIsPattern_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uri);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uri);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success('/[0-9]+/s');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodDoesNotMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success('/[0-9]+/s');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodPerfectMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->method);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(false);
        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(false);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertTrue($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(false);
        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(false);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertTrue($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortDoesNotMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success(rand(10000, 50000));

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternDoesNotMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success('/[a-z]+/s');

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->port);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(false);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertTrue($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternMatch_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->portPattern);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(false);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertTrue($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternMatch_withQueryParameter_requestHasNoQueryParameter_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->portPattern);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsHasQueryParameters_Success(false);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternMatch_withQueryParameters_parametersMatches_Success() {

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->portPattern);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsGetQueryParameters_Success($this->queryParameters);
        $this->controllerRuleCriteriaHelper->expectsGetQueryParameters_Success($this->queryParamPatterns);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertTrue($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternMatch_withQueryParameters_oneParameterIsMissing_Success() {

        $this->queryParamPatterns['another'] = 'should_fail';

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->portPattern);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsGetQueryParameters_Success($this->queryParameters);
        $this->controllerRuleCriteriaHelper->expectsGetQueryParameters_Success($this->queryParamPatterns);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }

    public function testMatch_uriPatternMatch_methodPatternMatch_withPortPatternMatch_withQueryParameters_parameterDoesNotMatch_Success() {

        $this->queryParamPatterns['some'] = '/[0-9]+/s';

        $this->httpRequestHelper->expectsGetURI_Success($this->uri);
        $this->controllerRuleCriteriaHelper->expectsGetURI_Success($this->uriPattern);
        $this->httpRequestHelper->expectsProcess_Success($this->httpRequestMock, $this->uriPattern);

        $this->httpRequestHelper->expectsGetMethod_Success($this->method);
        $this->controllerRuleCriteriaHelper->expectsGetMethod_Success($this->methodPattern);

        $this->controllerRuleCriteriaHelper->expectsHasPort_Success(true);
        $this->httpRequestHelper->expectsGetPort_Success($this->port);
        $this->controllerRuleCriteriaHelper->expectsGetPort_Success($this->portPattern);

        $this->controllerRuleCriteriaHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsHasQueryParameters_Success(true);
        $this->httpRequestHelper->expectsGetQueryParameters_Success($this->queryParameters);
        $this->controllerRuleCriteriaHelper->expectsGetQueryParameters_Success($this->queryParamPatterns);

        $match = $this->rule->match($this->httpRequestMock);

        $this->assertFalse($match);

    }
}
