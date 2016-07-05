<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRodsonRetrieverCriteria;
use iRESTful\Rodson\Domain\Repositories\Criterias\Exceptions\RodsonRetrieverCriteriaException;

final class ConcreteRodsonRetrieverCriteriaTest extends \PHPUnit_Framework_TestCase {
    private $filePath;
    public function setUp() {
        $this->filePath = __FILE__;
    }

    public function tearDown() {

    }

    public function testCreate_withFilePath_Success() {

        $criteria = new ConcreteRodsonRetrieverCriteria($this->filePath);

        $this->assertTrue($criteria->hasFilePath());
        $this->assertEquals($this->filePath, $criteria->getFilePath());

    }

    public function testCreate_withInvalidFilePath_throwsRodsonRetrieverCriteriaException() {

        $asserted = false;
        try {

            new ConcreteRodsonRetrieverCriteria(__DIR__.'/invalidfile.json');

        } catch (RodsonRetrieverCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringFilePath_throwsRodsonRetrieverCriteriaException() {

        $asserted = false;
        try {

            new ConcreteRodsonRetrieverCriteria(new \DateTime());

        } catch (RodsonRetrieverCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyFilePath_throwsRodsonRetrieverCriteriaException() {

        $asserted = false;
        try {

            new ConcreteRodsonRetrieverCriteria('');

        } catch (RodsonRetrieverCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withoutCriteria_throwsRodsonRetrieverCriteriaException() {

        $asserted = false;
        try {

            new ConcreteRodsonRetrieverCriteria();

        } catch (RodsonRetrieverCriteriaException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}
