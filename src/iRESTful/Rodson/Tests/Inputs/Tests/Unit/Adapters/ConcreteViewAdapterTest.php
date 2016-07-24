<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteViewAdapter;
use iRESTful\Rodson\Tests\Inputs\Helpers\Adapters\MethodAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Views\Exceptions\ViewException;

final class ConcreteViewAdapterTest extends \PHPUnit_Framework_TestCase {
    private $methodAdapterMock;
    private $methodMock;
    private $name;
    private $methodName;
    private $data;
    private $adapter;
    private $methodAdapterHelper;
    public function setUp() {
        $this->methodAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter');
        $this->methodMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Codes\Methods\Method');

        $this->name = 'my_view';
        $this->methodName = 'myMethod';

        $this->data = [
            'name' => $this->name,
            'method' => $this->methodName
        ];

        $this->adapter = new ConcreteViewAdapter($this->methodAdapterMock);

        $this->methodAdapterHelper = new MethodAdapterHelper($this, $this->methodAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToView_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $view = $this->adapter->fromDataToView($this->data);

        $this->assertEquals($this->name, $view->getName());
        $this->assertEquals($this->methodMock, $view->getMethod());

    }

    public function testFromDataToView_throwsMethodException_throwsViewException() {

        $this->methodAdapterHelper->expectsFromStringToMethod_throwsMethodException($this->methodName);

        $asserted = false;
        try {

            $this->adapter->fromDataToView($this->data);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToView_withoutName_throwsViewException() {

        unset($this->data['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToView($this->data);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToView_withoutMethod_throwsViewException() {

        unset($this->data['method']);

        $asserted = false;
        try {

            $this->adapter->fromDataToView($this->data);

        } catch (ViewException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToViews_Success() {

        $this->methodAdapterHelper->expectsFromStringToMethod_Success($this->methodMock, $this->methodName);

        $views = $this->adapter->fromDataToViews([
            $this->name => $this->methodName
        ]);

        $this->assertEquals($this->name, $views[$this->name]->getName());
        $this->assertEquals($this->methodMock, $views[$this->name]->getMethod());

    }

}
