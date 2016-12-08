<?php
namespace iRESTful\Rodson\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteDSL;
use iRESTful\Rodson\DSLs\Domain\Exceptions\DSLException;

final class ConcreteDSLTest extends \PHPUnit_Framework_TestCase {
    private $nameMock;
    private $urlMock;
    private $authorMock;
    private $projectMock;
    private $type;
    private $license;
    private $authors;
    private $urls;
    private $version;
    public function setUp() {
        $this->nameMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Names\Name');
        $this->urlMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\URLs\Url');
        $this->authorMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Authors\Author');
        $this->projectMock = $this->createMock('iRESTful\Rodson\DSLs\Domain\Projects\Project');

        $this->type = 'library';
        $this->license = 'MIT';

        $this->authors = [
            $this->authorMock,
            $this->authorMock
        ];

        $this->urls = [
            'homepage' => $this->urlMock,
            'repository' => $this->urlMock
        ];

        $this->version = '16.05.22';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $dsl = new ConcreteDSL($this->nameMock, $this->type, $this->urls, $this->license, $this->authors, $this->authorMock, $this->projectMock, $this->version);

        $this->assertEquals($this->nameMock, $dsl->getName());
        $this->assertEquals($this->type, $dsl->getType());
        $this->assertEquals($this->urls, $dsl->getUrls());
        $this->assertEquals($this->license, $dsl->getLicense());
        $this->assertEquals($this->authors, $dsl->getAuthors());
        $this->assertEquals($this->projectMock, $dsl->getProject());

    }

    public function testCreate_withOneInvalidAuthor_throwsDSLException() {

        $this->authors[] = new \DateTime();

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urls, $this->license, $this->authors, $this->authorMock, $this->projectMock, $this->version);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyAuthor_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urls, $this->license, [], $this->authorMock, $this->projectMock, $this->version);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyType_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, '', $this->urls, $this->license, $this->authors, $this->authorMock, $this->projectMock, $this->version);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyLicense_throwsDSLException() {

        $asserted = false;
        try {

            new ConcreteDSL($this->nameMock, $this->type, $this->urls, '', $this->authors, $this->authorMock, $this->projectMock, $this->version);

        } catch (DSLException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
