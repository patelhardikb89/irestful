<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\Adapters\RESTAPIAdapter;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Adapters\CredentialsAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteRESTAPI;
use iRESTful\DSLs\Domain\Projects\Databases\Credentials\Exceptions\CredentialsException;
use iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\Exceptions\RESTAPIException;
use iRESTful\DSLs\Domain\URLs\Adapters\UrlAdapter;

final class ConcreteRESTAPIAdapter implements RESTAPIAdapter {
    private $urlAdapter;
    private $credentialsAdapter;
    public function __construct(UrlAdapter $urlAdapter, CredentialsAdapter $credentialsAdapter) {
        $this->urlAdapter = $urlAdapter;
        $this->credentialsAdapter = $credentialsAdapter;
    }

    public function fromDataToRESTAPI(array $data) {

        if (!isset($data['base_url'])) {
            throw new RESTAPIException('The base_url keyname is mandatory in order to convert data to a RESTAPI object.');
        }

        if (!isset($data['port'])) {
            throw new RESTAPIException('The port keyname is mandatory in order to convert data to a RESTAPI object.');
        }

        try {

            $headerLine = null;
            if (isset($data['header_line'])) {
                $headerLine = $data['header_line'];
            }

            $credentials = null;
            if (isset($data['credentials'])) {
                $credentials = $this->credentialsAdapter->fromDataToCredentials($data['credentials']);
            }

            $baseUrl = $this->urlAdapter->fromStringToUrl($data['base_url']);
            return new ConcreteRESTAPI($baseUrl, $data['port'], $credentials, $headerLine);

        } catch (CredentialsException $exception) {
            throw new RESTAPIException('There was an exception while converting data to a Credentials object.', $exception);
        }

    }

}
