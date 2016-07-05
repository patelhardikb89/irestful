<?php
namespace iRESTful\Rodson\Tests\Tests\Functional\Repositories;
use iRESTful\Rodson\Infrastructure\Factories\ConcreteRodsonRepositoryFactory;

final class ConcreteRodsonRepositoryTest extends \PHPUnit_Framework_TestCase {
    private $filePath;
    private $repository;
    public function setUp() {

        $this->filepath = realpath(__DIR__.'/../../Files/authenticated.json');

        $factory = new ConcreteRodsonRepositoryFactory();
        $this->repository = $factory->create();
    }

    public function tearDown() {

    }

    public function testRetrieve_Success() {

        $rodson = $this->repository->retrieve([
            'file_path' => $this->filepath
        ]);

        //verify the rodson object later...

    }

}
