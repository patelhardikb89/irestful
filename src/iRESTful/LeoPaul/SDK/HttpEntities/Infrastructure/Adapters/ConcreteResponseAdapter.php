<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Adapters\ResponseAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;

final class ConcreteResponseAdapter implements ResponseAdapter {
    public function __construct() {

    }

    public function fromHttpResponseToData(HttpResponse $httpResponse) {

        $code = $httpResponse->getCode();
        if ($code == 404) {
            return null;
        }

        $content = $httpResponse->getContent();
        if ($code != 200) {
            $parentException = new ResponseException($content);
            throw new ResponseException('There was an exception while retrieving an Entity object.', $parentException);
        }

        if (empty($content)) {
            return null;
        }

        $data = @json_decode($content, true);
        if (!is_array($data) && empty($data)) {
            throw new ResponseException('The retrieved data is invalid.');
        }

        return $data;
    }

}
