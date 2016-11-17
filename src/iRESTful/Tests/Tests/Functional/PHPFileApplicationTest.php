<?php
namespace iRESTful\Tests\Tests\Functional;
use iRESTful\Applications\Infrastructure\Factories\ConcreteApplicationFactory;

final class PHPFileApplicationTest extends \PHPUnit_Framework_TestCase {
    private $filePath;
    private $outputFolderPath;
    private $templatePath;
    private $timezone;
    public function setUp() {

        //$folderName = 'Authenticated';
        //$jsonFileName = 'authenticated.json';

        $folderName = 'Profiles';
        $jsonFileName = 'profile.json';

        $this->filePath = realpath(__DIR__.'/../../Files/'.$folderName.'/'.$jsonFileName);
        $this->outputFolderPath = realpath(__DIR__.'/../../Files/'.$folderName.'/Output');
        $this->templatePath = '/vagrant/templates/code/php';
        $this->timezone = 'America/Montreal';

    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $applicationFactory = new ConcreteApplicationFactory($this->timezone, $this->templatePath, $this->filePath, $this->outputFolderPath);
        $applicationFactory->create()->execute();

        $this->assertTrue(true);

    }

}
