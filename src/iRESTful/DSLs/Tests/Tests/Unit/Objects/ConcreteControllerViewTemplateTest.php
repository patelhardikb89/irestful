<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteControllerViewTemplate;
use iRESTful\DSLs\Domain\Projects\Controllers\Views\Templates\Exceptions\TemplateException;

final class ConcreteControllerViewTemplateTest extends \PHPUnit_Framework_TestCase {
    private $path;
    private $keyname;
    public function setUp() {
        $this->path = __DIR__;
        $this->keyname = 'twig';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $template = new ConcreteControllerViewTemplate($this->path, $this->keyname);

        $this->assertEquals($this->path, $template->getPath());
        $this->assertEquals($this->keyname, $template->getProcessorKeyname());

    }

    public function testCreate_withEmptyProcessorKeyname_throwsTemplateException() {

        $asserted = false;
        try {

            new ConcreteControllerViewTemplate($this->path, '');

        } catch (TemplateException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidPath_throwsTemplateException() {

        $asserted = false;
        try {

            new ConcreteControllerViewTemplate('/just/an/invalid/path', $this->keyname);

        } catch (TemplateException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
