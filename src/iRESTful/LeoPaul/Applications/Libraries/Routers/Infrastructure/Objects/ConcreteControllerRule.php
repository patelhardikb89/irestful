<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Routers\Infrastructure\Objects;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\ControllerRule;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Controller;
use iRESTful\LeoPaul\Applications\Libraries\Routers\Domain\Controllers\Rules\Criterias\ControllerRuleCriteria;

final class ConcreteControllerRule implements ControllerRule {
    private $criteria;
    private $controller;
    public function __construct(ControllerRuleCriteria $criteria, Controller $controller) {
        $this->criteria = $criteria;
        $this->controller = $controller;
    }

    public function match(HttpRequest $request) {

        $match = function($pattern, $value) {

            if ($pattern == $value) {
                return true;
            }

            //replace the variable to a regex:
            $pattern = preg_replace('/\$([^$]+)\$/s', '[^/]+', $pattern);
            $pattern = str_replace('\/', '/', $pattern);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/'.$pattern.'/s';

            $matches = [];
            @preg_match_all($pattern, $value, $matches);
            return isset($matches[0][0]) && ($matches[0][0] == $value);


        };

        $uri = $request->getURI();
        $pattern = $this->criteria->getURI();
        $request = $request->process($pattern);
        if (!$match($pattern, $uri)) {
            return false;
        }

        $method = $request->getMethod();
        $pattern = $this->criteria->getMethod();
        if (!$match($pattern, $method)) {
            return false;
        }

        if ($this->criteria->hasPort()) {
            $port = $request->getPort();
            $pattern = $this->criteria->getPort();
            if (!$match($pattern, $port)) {
                return false;
            }
        }

        if ($this->criteria->hasQueryParameters()) {

            if (!$request->hasQueryParameters()) {
                return false;
            }

            $queryParameters = $request->getQueryParameters();
            $patterns = $this->criteria->getQueryParameters();
            foreach($patterns as $keyname => $onePattern) {

                if (!isset($queryParameters[$keyname])) {
                    return false;
                }

                if (!$match($onePattern, $queryParameters[$keyname])) {
                    return false;
                }

            }
        }

        return true;

    }

    public function getController() {
        return $this->controller;
    }

}
