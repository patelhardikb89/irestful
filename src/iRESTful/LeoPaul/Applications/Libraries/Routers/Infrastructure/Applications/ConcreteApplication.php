<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Applications;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Applications\Application;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Configs\Adapters\ConfigurationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\AuthenticateException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\AuthorizationException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidDataException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidMediaException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\NotFoundException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\InvalidRequestException;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Exceptions\ServerException;

final class ConcreteApplication implements Application {
    private $configs;
    private $requestAdapter;
    private $configurationAdapter;
    private $headerFn;
    private $httpResponseCodeFn;
    public function __construct(
        array $configs,
        HttpRequestAdapter $requestAdapter,
        ConfigurationAdapter $configurationAdapter,
        $headerFn = 'header',
        $httpResponseCodeFn = 'http_response_code'
    ) {
        $this->configs = $configs;
        $this->requestAdapter = $requestAdapter;
        $this->configurationAdapter = $configurationAdapter;
        $this->headerFn = $headerFn;
        $this->httpResponseCodeFn = $httpResponseCodeFn;
    }

    public function execute(array $data) {

        $httpResponseCodeFn = $this->httpResponseCodeFn;
        $render = function($message, $code) use(&$httpResponseCodeFn) {
            $httpResponseCodeFn($code);
            echo $message;
        };

        $headerFn = $this->headerFn;
        $execute = function(Controller $controller, HttpRequest $request) use(&$render, &$headerFn, &$httpResponseCodeFn) {

            $response = $controller->execute($request);
            $headers = $response->getHeaders();
            foreach($headers as $oneHeader) {
                $headerFn($oneHeader);
            }

            if (!$response->hasOutput()) {
                $httpResponseCodeFn(204);
                return;
            }

            $output = $response->getOutput();
            $render($output, 200);
        };

        try {

            $request = $this->requestAdapter->fromDataToHttpRequest($data);
            $configs = $this->configurationAdapter->fromDataToConfiguration($this->configs);

            $rules = $configs->getControllerRules();
            foreach($rules as $oneRule) {

                //there is a match!  Execute the controller:
                if ($oneRule->match($request)) {
                    $controller = $oneRule->getController();
                    $execute($controller, $request);
                    return;
                }

            }

            //check if there is a not found controller:
            if (!$configs->hasNotFoundController()) {
                throw new NotFoundException('There was no controller to load for this request.');
            }

            //no controller found, so execute the not found controller:
            $controller = $configs->getNotFoundController();
            $execute($controller, $request);

        } catch(InvalidRequestException $exception) {
            $message = $exception->getMessage();
            $render($message, 400);
        } catch (AuthenticateException $exception) {
            $message = $exception->getMessage();
            $render($message, 401);
        } catch (AuthorizationException $exception) {
            $message = $exception->getMessage();
            $render($message, 403);
        } catch (InvalidDataException $exception) {
            $message = $exception->getMessage();
            $render($message, 422);
        } catch (InvalidMediaException $exception) {
            $message = $exception->getMessage();
            $render($message, 415);
        } catch (NotFoundException $exception) {
            $message = $exception->getMessage();
            $render($message, 404);
        } catch(ServerException $exception) {
            $message = $exception->getMessage();
            $render($message, 500);
        } catch (\Exception $exception) {
            $render('There was a problem with the server.', 500);
        }
    }

}
