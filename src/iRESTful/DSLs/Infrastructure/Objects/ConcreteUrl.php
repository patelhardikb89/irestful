<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\URLs\Url;
use iRESTful\DSLs\Domain\URLs\Exceptions\UrlException;

final class ConcreteUrl implements Url {
    private $url;
    public function __construct(string $url) {

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UrlException('The given url ('.$url.') is invalid.');
        }

        $this->url = $url;
    }

    public function get() {
        return $this->url;
    }

}
