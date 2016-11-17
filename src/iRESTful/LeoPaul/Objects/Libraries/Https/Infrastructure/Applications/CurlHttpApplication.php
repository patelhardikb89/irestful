<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Applications;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\HttpRequest;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects\ConcreteHttpResponse;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Requests\Adapters\HttpRequestAdapter;

final class CurlHttpApplication implements HttpApplication {
    private $httpRequestAdapter;
    private $baseUrl;
    public function __construct(HttpRequestAdapter $httpRequestAdapter, $baseUrl) {

        if (!filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            throw new HttpException('The url ('.$baseUrl.') must be a valid url.');
        }

        $this->httpRequestAdapter = $httpRequestAdapter;
        $this->baseUrl = $baseUrl;
    }

    public function execute(array $httpRequest) {

        $request = $this->httpRequestAdapter->fromDataToHttpRequest($httpRequest);

        $uri = $request->getURI();
        $httpMethod = $request->getMethod();
        $port = $request->getPort();

        $queryParameters = array();
        if ($request->hasQueryParameters()) {
            $queryParameters = $request->getQueryParameters();
        }

        $requestParameters = array();
        if ($request->hasRequestParameters()) {
            $requestParameters = $request->getRequestParameters();
        }

        $headers = array();
        if ($request->hasHeaders()) {
            $headers = $request->getHeaders();
        }

        $file = null;
        if ($request->hasFilePath()) {
            $file = $request->getFilePath();
        }

        return $this->executeCurl($uri, $httpMethod, $port, $queryParameters, $requestParameters, $headers, $file);
    }

    private function executeCurl($uri, $httpMethod, $port, array $queryParameters, array $requestParameters, array $headers, $file = null) {

        foreach($requestParameters as $keyname => $oneValue) {

            if (is_null($oneValue)) {
                $requestParameters[$keyname] = '';
            }

        }

        $url = $this->baseUrl.$uri;

        $curl = curl_init();
        $curlParams = array();

        $curlParams[CURLINFO_HEADER_OUT] = true;
        $curlParams[CURLOPT_CUSTOMREQUEST] = strtoupper($httpMethod);

        if (!empty($requestParameters)) {
            $curlParams[CURLOPT_POSTFIELDS] = http_build_query($requestParameters);
        }

        if (!empty($headers)) {

            $lines = [];
            foreach($headers as $keyname => $value) {
                $lines[] = $keyname.': '.trim($value);
            }

            $curlParams[CURLOPT_HTTPHEADER] = $lines;
        }

        if (!empty($queryParameters)) {
            $url = $url.'?'.http_build_query($queryParameters);
        }

        $curlParams[CURLOPT_URL] = $url;
        $curlParams[CURLOPT_RETURNTRANSFER] = true;

        if (!empty($file)) {
            $curlParams[CURLOPT_POSTFIELDS] = ['file' => new \CurlFile($file)];
        }

        $curlParams[CURLOPT_FOLLOWLOCATION] = true;

        if ($port != 80) {
            $curlParams[CURLOPT_PORT] = $port;
        }

        curl_setopt_array($curl, $curlParams);
        $content = curl_exec($curl);
        $content = (empty($content)) ? '' : $content;
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $outputHeaders = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        curl_close($curl);

        $headerLines = $this->getHeaderLines($outputHeaders);
        return new ConcreteHttpResponse($statusCode, $content, $headerLines);
    }

    private function getHeaderLines($content) {

        $output = [];
        $lines = explode(PHP_EOL, $content);
        foreach($lines as $oneLine) {

            if (empty($oneLine)) {
                continue;
            }

            $pos = strpos($oneLine, ':');
            if ($pos === false) {
                continue;
            }

            $exploded = explode(':', $oneLine);
            $name = trim($exploded[0]);
            unset($exploded[0]);

            $output[$name] = trim(implode(':', $exploded));

        }

        return $output;

    }

}
