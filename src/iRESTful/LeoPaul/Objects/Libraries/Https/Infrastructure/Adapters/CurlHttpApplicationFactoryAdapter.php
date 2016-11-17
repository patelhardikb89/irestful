<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Factories\CurlHttpApplicationFactory;

final class CurlHttpApplicationFactoryAdapter implements HttpApplicationFactoryAdapter {

    public function __construct() {

    }

    public function fromDataToHttpApplicationFactory(array $data) {

        if (!isset($data['base_url'])) {
            throw new HttpException('The base_url keyname is mandatory in order to convert data to an HttpApplicationFactory object.');
        }

        return new CurlHttpApplicationFactory($data['base_url']);
    }

}
