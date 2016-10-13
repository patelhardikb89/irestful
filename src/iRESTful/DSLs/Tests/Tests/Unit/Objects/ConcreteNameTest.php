<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Domain\Names\Exceptions\NameException;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteName;

final class ConcreteNameTest extends \PHPUnit_Framework_TestCase {
    private $projectName;
    private $organizationName;
    private $name;
    public function setUp() {
        $this->projectName = 'watson';
        $this->organizationName = 'IBM';
        $this->name = $this->organizationName.'/'.$this->projectName;
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $name = new ConcreteName($this->projectName, $this->organizationName);

        $this->assertEquals($this->projectName, $name->getProjectName());
        $this->assertEquals($this->organizationName, $name->getOrganizationName());
        $this->assertEquals($this->name, $name->getName());
    }

    public function testCreate_withEmptyProjectName_throwsNameException() {

        $asserted = false;
        try {

            new ConcreteName('', $this->organizationName);

        } catch (NameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testCreate_withEmptyOrganizationName_throwsNameException() {

        $asserted = false;
        try {

            new ConcreteName($this->projectName, '');

        } catch (NameException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}
