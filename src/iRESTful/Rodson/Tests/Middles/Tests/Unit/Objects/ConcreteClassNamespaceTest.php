<?php
namespace iRESTful\Rodson\Tests\Middles\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\Exceptions\NamespaceException;

final class ConcreteClassNamespaceTest extends \PHPUnit_Framework_TestCase {
    private $namespace;
    public function setUp() {
        $this->namespace = [
            'Rodson',
            'Tests'
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $namespace = new ConcreteClassNamespace($this->namespace);

        $this->assertEquals($this->namespace, $namespace->getAll());

    }

    public function testCreate_withEmptyNamespace_throwsNamespaceException() {

        $asserted = false;
        try {

            new ConcreteClassNamespace([]);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneEmptyNamespacePart_throwsNamespaceException() {

        $this->namespace[] = '';

        $asserted = false;
        try {

            new ConcreteClassNamespace($this->namespace);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneNonStringNamespacePart_throwsNamespaceException() {

        $this->namespace[] = '';

        $asserted = false;
        try {

            new ConcreteClassNamespace($this->namespace);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
