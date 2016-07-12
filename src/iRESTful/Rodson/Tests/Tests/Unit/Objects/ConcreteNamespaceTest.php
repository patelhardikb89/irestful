<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteNamespace;
use iRESTful\Rodson\Domain\Outputs\Namespaces\Exceptions\NamespaceException;

final class ConcreteNamespaceTest extends \PHPUnit_Framework_TestCase {
    private $namespace;
    private $output;
    public function setUp() {
        $this->namespace = [
            'Rodson',
            'Tests'
        ];

        $this->output = 'Rodson\\Tests';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $namespace = new ConcreteNamespace($this->namespace);

        $this->assertEquals($this->output, $namespace->get());

    }

    public function testCreate_withEmptyNamespace_throwsNamespaceException() {

        $asserted = false;
        try {

            new ConcreteNamespace([]);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneEmptyNamespacePart_throwsNamespaceException() {

        $this->namespace[] = '';

        $asserted = false;
        try {

            new ConcreteNamespace($this->namespace);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withOneNonStringNamespacePart_throwsNamespaceException() {

        $this->namespace[] = '';

        $asserted = false;
        try {

            new ConcreteNamespace($this->namespace);

        } catch (NamespaceException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
