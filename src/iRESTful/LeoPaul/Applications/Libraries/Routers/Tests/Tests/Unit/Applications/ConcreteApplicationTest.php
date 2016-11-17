<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Tests\Unit\Applications;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Applications\ConcreteApplication;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Adapters\ConfigurationAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects\ConfigurationHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters\HttpRequestAdapterHelper;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRequestHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects\ControllerRuleHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects\ControllerHelper;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Tests\Helpers\Objects\ControllerResponseHelper;

final class ConcreteApplicationTest extends \PHPUnit_Framework_TestCase {
    private $configurationAdapterMock;
    private $configurationMock;
    private $httpRequestAdapterMock;
    private $httpRequestMock;
    private $controllerRuleMock;
    private $controllerMock;
    private $controllerResponseMock;
    private $request;
    private $configs;
    private $rules;
    private $headers;
    private $output;
    private $application;
    private $configurationAdapterHelper;
    private $configurationHelper;
    private $httpRequestAdapterHelper;
    private $httpRequestHelper;
    private $controllerRuleHelper;
    private $controllerHelper;
    private $controllerResponseHelper;
    public function setUp() {
        $this->configurationAdapterMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Adapters\ConfigurationAdapter');
        $this->configurationMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Configuration');
        $this->httpRequestAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter');
        $this->httpRequestMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest');
        $this->controllerRuleMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule');
        $this->controllerMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller');
        $this->controllerResponseMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Responses\ControllerResponse');

        $this->request = [
            'some' => 'request'
        ];

        $this->configs = [
            'some' => 'configs'
        ];

        $this->rules = [
            $this->controllerRuleMock
        ];

        $this->headers = [
            'Content-Type: application/json'
        ];

        $this->output = 'some output';

        $this->application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock);

        $this->configurationAdapterHelper = new ConfigurationAdapterHelper($this, $this->configurationAdapterMock);
        $this->configurationHelper = new ConfigurationHelper($this, $this->configurationMock);
        $this->httpRequestAdapterHelper = new HttpRequestAdapterHelper($this, $this->httpRequestAdapterMock);
        $this->httpRequestHelper = new HttpRequestHelper($this, $this->httpRequestMock);
        $this->controllerRuleHelper = new ControllerRuleHelper($this, $this->controllerRuleMock);
        $this->controllerHelper = new ControllerHelper($this, $this->controllerMock);
        $this->controllerResponseHelper = new ControllerResponseHelper($this, $this->controllerResponseMock);

    }

    public function tearDown() {

    }

    public function testExecute_controllerIsMatch_withHeaders_withOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success($this->headers);
        $this->controllerResponseHelper->expectsHasOutput_Success(true);
        $this->controllerResponseHelper->expectsGetOutput_Success($this->output);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($this->output, $output);
        $this->assertEquals($this->headers, $headers);
    }

    public function testExecute_controllerIsMatch_withHeaders_withoutOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success($this->headers);
        $this->controllerResponseHelper->expectsHasOutput_Success(false);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('', $output);
        $this->assertEquals($this->headers, $headers);
    }

    public function testExecute_controllerIsMatch_withEmptyHeaders_withoutOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success([]);
        $this->controllerResponseHelper->expectsHasOutput_Success(false);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('', $output);
        $this->assertEquals([], $headers);
    }

    public function testExecute_controllerIsNoMatch_withNotFoundController_withHeaders_withOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(false);
        $this->configurationHelper->expectsHasNotFoundController_Success(true);
        $this->configurationHelper->expectsGetNotFoundController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success($this->headers);
        $this->controllerResponseHelper->expectsHasOutput_Success(true);
        $this->controllerResponseHelper->expectsGetOutput_Success($this->output);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($this->output, $output);
        $this->assertEquals($this->headers, $headers);
    }

    public function testExecute_controllerIsNoMatch_withNotFoundController_withHeaders_withoutOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(false);
        $this->configurationHelper->expectsHasNotFoundController_Success(true);
        $this->configurationHelper->expectsGetNotFoundController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success($this->headers);
        $this->controllerResponseHelper->expectsHasOutput_Success(false);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('', $output);
        $this->assertEquals($this->headers, $headers);
    }

    public function testExecute_controllerIsNoMatch_withNotFoundController_withoutHeaders_withOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(false);
        $this->configurationHelper->expectsHasNotFoundController_Success(true);
        $this->configurationHelper->expectsGetNotFoundController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success([]);
        $this->controllerResponseHelper->expectsHasOutput_Success(true);
        $this->controllerResponseHelper->expectsGetOutput_Success($this->output);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($this->output, $output);
        $this->assertEquals([], $headers);
    }

    public function testExecute_controllerIsNoMatch_withNotFoundController_withoutHeaders_withoutOutput_Success() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(false);
        $this->configurationHelper->expectsHasNotFoundController_Success(true);
        $this->configurationHelper->expectsGetNotFoundController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_Success($this->controllerResponseMock, $this->httpRequestMock);
        $this->controllerResponseHelper->expectsGetHeaders_Success([]);
        $this->controllerResponseHelper->expectsHasOutput_Success(false);

        $headers = [];
        $headerFn = function($line) use(&$headers) {
            $headers[] = $line;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, $headerFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('', $output);
        $this->assertEquals([], $headers);
    }

    public function testExecute_controllerIsNoMatch_withoutNotFoundController_throwsNotFoundException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(false);
        $this->configurationHelper->expectsHasNotFoundController_Success(false);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('There was no controller to load for this request.', $output);
        $this->assertEquals(404, $code);
    }

    public function testExecute_throwsAuthenticateException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsAuthenticateException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(401, $code);
    }

    public function testExecute_throwsAuthorizationException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsAuthorizationException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(403, $code);
    }

    public function testExecute_throwsInvalidDataException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsInvalidDataException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(422, $code);
    }

    public function testExecute_throwsInvalidMediaException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsInvalidMediaException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(415, $code);
    }

    public function testExecute_throwsNotFoundException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsNotFoundException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(404, $code);
    }

    public function testExecute_throwsServerException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_Success($this->configurationMock, $this->configs);
        $this->configurationHelper->expectsGetControllerRules_Success($this->rules);
        $this->controllerRuleHelper->expectsMatch_Success(true);
        $this->controllerRuleHelper->expectsGetController_Success($this->controllerMock);
        $this->controllerHelper->expectsExecute_throwsServerException($this->httpRequestMock);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('TEST', $output);
        $this->assertEquals(500, $code);
    }

    public function testExecute_throwsConfigurationException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_Success($this->httpRequestMock, $this->request);
        $this->configurationAdapterHelper->expectsFromDataToConfiguration_throwsConfigurationException($this->configs);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('There was a problem with the server.', $output);
        $this->assertEquals(500, $code);
    }

    public function testExecute_throwsHttpException() {

        $this->httpRequestAdapterHelper->expectsFromDataToHttpRequest_throwsHttpException($this->request);

        $code = null;
        $httpResponseCodeFn = function($element) use(&$code) {
            $code = $element;
        };

        $application = new ConcreteApplication($this->configs, $this->httpRequestAdapterMock, $this->configurationAdapterMock, null, $httpResponseCodeFn);

        ob_start();
            $application->execute($this->request);
            $output = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('There was a problem with the server.', $output);
        $this->assertEquals(500, $code);
    }

}
