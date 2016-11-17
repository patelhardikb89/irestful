<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Infrastructure\Adapters\ConcreteResponseAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpResponseHelper;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Responses\Exceptions\ResponseException;

final class ConcreteResponseAdapterTest extends \PHPUnit_Framework_TestCase {
    private $httpResponseMock;
    private $content;
    private $code;
    private $container;
    private $data;
    private $adapter;
    private $httpResponseHelper;
    public function setUp() {
        $this->httpResponseMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse');

        $this->code = 200;
        $this->data = [
            'uuid' => 'a367574e-9b29-4d1c-98cd-da1799f96646',
            'title' => 'Some Title',
            'description' => 'Some description',
            'created_on' => time()
        ];

        $this->content = json_encode($this->data);

        $this->adapter = new ConcreteResponseAdapter();

        $this->httpResponseHelper = new HttpResponseHelper($this, $this->httpResponseMock);
    }

    public function tearDown() {

    }

    public function testFromHttpResponseToData_Success() {
        $this->httpResponseHelper->expectsGetCode_Success($this->code);
        $this->httpResponseHelper->expectsGetContent_Success($this->content);

        $data = $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        $this->assertEquals($this->data, $data);
    }

    public function testFromHttpResponseToData_withEmptyArrayContent_Success() {
        $this->httpResponseHelper->expectsGetCode_Success($this->code);
        $this->httpResponseHelper->expectsGetContent_Success('[]');

        $data = $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        $this->assertEquals([], $data);
    }

    public function testFromHttpResponseToData_with404Code_Success() {
        $this->httpResponseHelper->expectsGetCode_Success(404);

        $data = $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        $this->assertNull($data);
    }

    public function testFromHttpResponseToData_withEmptyContent_Success() {
        $this->httpResponseHelper->expectsGetCode_Success($this->code);
        $this->httpResponseHelper->expectsGetContent_Success('');

        $data = $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        $this->assertNull($data);
    }

    public function testFromHttpResponseToData_with500Code_throwsResponseException() {
        $this->httpResponseHelper->expectsGetCode_Success(500);
        $this->httpResponseHelper->expectsGetContent_Success($this->content);

        $asserted = false;
        try {

            $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        } catch (ResponseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromHttpResponseToData_withInvalidContent_throwsResponseException() {
        $this->httpResponseHelper->expectsGetCode_Success($this->code);
        $this->httpResponseHelper->expectsGetContent_Success('this is not json content.');

        $asserted = false;
        try {

            $this->adapter->fromHttpResponseToData($this->httpResponseMock);

        } catch (ResponseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }
}
