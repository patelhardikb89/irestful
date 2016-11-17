<?php
namespace iRESTful\Rodson\Tests\Tests\Functional;
use iRESTful\Rodson\Applications\Infrastructure\Factories\ConcreteApplicationFactory;

final class PHPFileApplicationTest extends \PHPUnit_Framework_TestCase {
    private $filePath;
    private $outputFolderPath;
    private $templatePath;
    private $timezone;
    public function setUp() {

        $folderName = 'Authenticated';
        $jsonFileName = 'authenticated.json';

        $this->filePath = '/vagrant/src/iRESTful/Products/'.$folderName.'/CRUD/'.$jsonFileName;
        $this->outputFolderPath = '/vagrant/build/'.$folderName.'/CRUD';
        $this->templatePath = '/vagrant/templates/rodson/code/php';
        $this->timezone = 'America/Montreal';

        if (!is_dir($this->outputFolderPath)) {
            mkdir($this->outputFolderPath, 777, true);
        }

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $applicationFactory = new ConcreteApplicationFactory($this->timezone, $this->templatePath, $this->filePath, $this->outputFolderPath);
        $applicationFactory->create()->execute();

        $this->assertTrue(true);

    }

}
