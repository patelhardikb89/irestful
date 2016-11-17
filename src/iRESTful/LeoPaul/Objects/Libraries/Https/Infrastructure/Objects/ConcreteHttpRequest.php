<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRequest implements HttpRequest {
    private $uri;
    private $httpMethod;
    private $port;
    private $queryParameters;
    private $requestParameters;
    private $filePath;
    private static $possibleHttpMethods = array('get', 'post', 'put', 'delete', 'options');

    /**
    *   @uri -> getURI() -> uri
    *   @httpMethod -> getMethod() -> http_method
    *   @port -> getPort() -> port
    */
    public function __construct($uri, $httpMethod, $port, array $queryParameters = null, array $requestParameters = null, array $headers = null, $filePath = null) {

        $port = (int) $port;
        if (!is_null($queryParameters) && empty($queryParameters)) {
            $queryParameters = null;
        }

        if (!is_null($headers) && empty($headers)) {
            $headers = null;
        }

        if (!is_null($requestParameters) && empty($requestParameters)) {
            $requestParameters = null;
        }

        if (!is_string($uri)) {
            throw new HttpException('The uri must be a string.');
        }

        if (empty($port)) {
            throw new HttpException('The port must be a non-empty integer.');
        }

        $httpMethod = strtolower($httpMethod);
        if (!in_array($httpMethod, self::$possibleHttpMethods)) {
            throw new HttpException('The httpMethod must be one of these: '.implode(',', self::$possibleHttpMethods));
        }

        if (!is_null($filePath) && !file_exists($filePath)) {
            throw new HttpException('The filepath ('.$filePath.') is invalid.');
        }

        $this->uri = $uri;
        $this->httpMethod = $httpMethod;
        $this->port = $port;
        $this->queryParameters = $queryParameters;
        $this->requestParameters = $requestParameters;
        $this->headers = $headers;
        $this->filePath = (empty($filePath)) ? null : realpath($filePath);

    }

    public function process($uriPattern) {

        $separatedPattern = $this->separatePattern($uriPattern);
        $queryParameters = $this->executePatterns($separatedPattern, $this->uri);

        if (empty($queryParameters)) {
            return $this;
        }

        if (empty($this->queryParameters)) {
            $this->queryParameters = [];
        }

        $this->queryParameters = array_merge($this->queryParameters, $queryParameters);
        return $this;
    }

    public function getURI() {
        return $this->uri;
    }

    public function getMethod() {
        return $this->httpMethod;
    }

    public function getPort() {
        return $this->port;
    }

    public function hasQueryParameters() {
        return !empty($this->queryParameters);
    }

    public function getQueryParameters() {
        return $this->queryParameters;
    }

    public function hasRequestParameters() {
        return !empty($this->requestParameters);
    }

    public function getRequestParameters() {
        return $this->requestParameters;
    }

    public function hasParameters() {
        return ($this->hasRequestParameters() || $this->hasQueryParameters());
    }

    public function getParameters() {
        $query = empty($this->queryParameters) ? [] : $this->queryParameters;
        $request = empty($this->requestParameters) ? [] : $this->requestParameters;
        $output = array_merge($query, $request);
        return empty($output) ? null : $output;
    }

    public function hasHeaders() {
        return !empty($this->headers);
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function hasFilePath() {
        return !empty($this->filePath);
    }

    public function getFilePath() {
        return $this->filePath;
    }

    private function separatePattern($pattern) {
        $matches = [];
        preg_match_all('/\$([^$]+)\$/s', $pattern, $matches);
        if (!isset($matches[1][0]) || (empty($matches[1][0]))) {
            return [
                'pattern' => $pattern
            ];
        }

        $definedSubPatterns = [];
        $subPatterns = $matches[1];
        $subPatternWithDelimiters = $matches[0];
        foreach($subPatterns as $index => $oneSubPattern) {

            //modify the original pattern:
            $pattern = str_replace($subPatternWithDelimiters[$index], '([^\/]*)', $pattern);

            if (strpos($oneSubPattern, '|') !== false) {
                $exploded = explode('|', $oneSubPattern);
                if (count($exploded) != 2) {
                    return [
                        'pattern' => $pattern
                    ];
                }

                $definedSubPatterns[] = [
                    'pattern' => $exploded[0],
                    'variable' => $exploded[1]
                ];

                continue;
            }

            $definedSubPatterns[] = [
                'pattern' => '[\s\S]+',
                'variable' => $oneSubPattern
            ];
        }

        $pattern = str_replace('\/', '/', $pattern);
        $pattern = str_replace('/', '\/', $pattern);

        return [
            'pattern' => $pattern,
            'sub_patterns' => $definedSubPatterns
        ];
    }

    private function executePatterns(array $seperatedPattern, $value) {
        $retrieve = function($pattern, $value) {
            $matches = [];
            @preg_match_all('/'.$pattern.'/s', $value, $matches);
            return $matches;
        };

        $matches = $retrieve($seperatedPattern['pattern'], $value);
        if (!isset($seperatedPattern['sub_patterns'])) {
            return (isset($matches[0][0]) && ($matches[0][0] == $value));
        }

        if (!isset($matches[1]) || !is_array($matches[1]) || empty($matches[1])) {
            return null;
        }

        $queryParameters = [];
        unset($matches[0]);
        $matches = array_values($matches);
        foreach($matches as $index => $oneVariableValue) {

            $oneVariableValue = (is_array($oneVariableValue) && isset($oneVariableValue[0])) ? $oneVariableValue[0] : $oneVariableValue;
            $variable = $seperatedPattern['sub_patterns'][$index]['variable'];
            $subPattern = $seperatedPattern['sub_patterns'][$index]['pattern'];

            $matches = $retrieve($subPattern, $oneVariableValue);
            if (!isset($matches[0][0]) || ($matches[0][0] != $oneVariableValue)) {
                return null;
            }

            $queryParameters[$variable] = $oneVariableValue;
        }

        return $queryParameters;
    }

}
