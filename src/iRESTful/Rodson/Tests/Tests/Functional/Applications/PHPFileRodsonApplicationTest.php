<?php
namespace iRESTful\Rodson\Tests\Tests\Functional\Applications;
use iRESTful\Rodson\Infrastructure\Applications\PHPFileRodsonApplication;

final class PHPFileRodsonApplicationTest extends \PHPUnit_Framework_TestCase {
    private $application;
    private $filePath;
    private $outputFolderPath;
    public function setUp() {

        $this->application = new PHPFileRodsonApplication(['iRESTful']);

        $this->filePath = realpath(__DIR__.'/../../Files/authenticated.json');
        $this->outputFolderPath = realpath(__DIR__.'/../../Files/Output');

    }

    public function tearDown() {

    }

    public function testExecuteByFile_Success() {

        $this->application->executeByFile($this->filePath, $this->outputFolderPath);

    }

}
