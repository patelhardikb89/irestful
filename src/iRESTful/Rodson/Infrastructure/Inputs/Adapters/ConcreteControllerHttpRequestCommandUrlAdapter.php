<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Adapters\UrlAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Exceptions\UrlException;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteControllerHttpRequestCommandUrl;

final class ConcreteControllerHttpRequestCommandUrlAdapter implements UrlAdapter {

    public function __construct() {

    }

    public function fromStringToUrl($string) {

        $parsed = parse_url($string);
        if (empty($parsed)) {
            throw new UrlException('The given url ('.$string.') is invalid.');
        }

        if (!isset($parsed['scheme'])) {
            throw new UrlException('The given url ('.$string.') must contain a scheme.');
        }

        if (!isset($parsed['host'])) {
            throw new UrlException('The given url ('.$string.') must contain a host.');
        }

        if (!isset($parsed['path'])) {
            throw new UrlException('The given url ('.$string.') must contain a path.');
        }

        $port = null;
        $endpoint = $parsed['path'];
        $exploded = explode(':', $parsed['path']);
        if (count($exploded) == 2) {
            $endpoint = $exploded[0];
            $port = (int) $exploded[1];
        }

        $baseUrl = $parsed['scheme'].'://'.$parsed['host'];
        return new ConcreteControllerHttpRequestCommandUrl($baseUrl, $endpoint, $port);

    }

}
