<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpResponse implements HttpResponse {
    private $code;
    private $content;
    private $headers;
    /**
    *   @code -> getCode() -> code
    *   @content -> getContent() -> content
    */
    public function __construct($code, $content, array $headers = null) {

        if (empty($headers)) {
            $headers = null;
        }

        $code = (int) $code;
        if (empty($code)) {
            throw new HttpException('The code must be a non-empty integer.');
        }

        if ($code <= 0) {
            throw new HttpException('The code must be greater than 0.');
        }

        if (!is_string($content)) {
            throw new HttpException('The content must be a string.');
        }

        $this->code = $code;
        $this->content = $content;
        $this->headers = $headers;

    }

    public function getCode() {
        return $this->code;
    }

    public function getContent() {
        return $this->content;
    }

    public function hasHeaders() {
        return !empty($this->headers);
    }

    public function getHeaders() {
        return $this->headers;
    }

}
