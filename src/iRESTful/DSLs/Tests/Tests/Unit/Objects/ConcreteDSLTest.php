<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteDSL;
use iRESTful\DSLs\Domain\Exceptions\DSLException;

final class ConcreteDSLTest extends \PHPUnit_Framework_TestCase {
    private $nameMock;
    private $urlMock;
    private $authorMock;
    private $projectMock;
    private $type;
    private $license;
    private $authors;
    public function setUp() {
        $this->nameMock = $this->createMock('iRESTful\DSLs\Domain\Names\Name');
        $this->urlMock = $this->createMock('iRESTful\DSLs\Domain\URLs\Url');
        $this->authorMock = $this->createMock('iRESTful\DSLs\Domain\Authors\Author');
        $this->projectMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Project');

        $this->type = 'library';
        $this->license = 'MIT';

        $this->authors = [
            $this->authorMock,
            $this->authorMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $dsl = new ConcreteDSL($this->nameMock, $this->type, $this->urlMock, $this->license, $this->authors, $this->projectMock);

        $this->assertEquals($this->nameMock, $dsl->getName());
        $this->assertEquals($this->type, $dsl->getType());
        $this->assertEquals($this->urlMock, $dsl->getUrl());
        $this->assertEquals($this->license, $dsl->getLicense());
        $this->assertEquals($this->authors, $dsl->getAuthors());
        $this->assertEquals($this->projectMock, $dsl->getProject());

    }

    public function testCreate_withOneInvalidAuthor_throwsDSLException() {

        $this->authors[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urlMock, $this->license, $this->authors, $this->projectMock);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyAuthor_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urlMock, $this->license, [], $this->projectMock);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyType_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, '', $this->urlMock, $this->license, $this->authors, $this->projectMock);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyLicense_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urlMock, '', $this->authors, $this->projectMock);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
