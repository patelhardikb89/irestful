<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\HttpRoute;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRoute implements HttpRoute {
    private $method;
    private $endpoint;
    private $className;
    private static $possibleMethods = array('get', 'post', 'put', 'patch', 'delete', 'options');
    public function __construct($method, $endpoint, $className) {

        if (!is_string($method) || empty($method)) {
            throw new HttpException('The http method must be a non-empty string.');
        }

        if (!is_string($endpoint) || empty($endpoint)) {
            throw new HttpException('The endpoint must be a non-empty string.');
        }

        if (!is_string($className) || empty($className)) {
            throw new HttpException('The className must be a non-empty string.');
        }

        if (!in_array($method, self::$possibleMethods)) {
            throw new HttpException('The http method ('.$method.') must be one of these: '.implode(', ', self::$possibleMethods));
        }

        if (!class_exists($className)) {
            throw new HttpException('The className ('.$className.') is invalid.');
        }

        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->className = $className;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getEndpoint() {
        return $this->endpoint;
    }

    public function getClassName() {
        return $this->className;
    }

}
