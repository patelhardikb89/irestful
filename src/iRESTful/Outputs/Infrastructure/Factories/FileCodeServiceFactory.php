<?php
namespace iRESTful\Outputs\Infrastructure\Factories;
use iRESTful\Outputs\Domain\Codes\Services\Factories\CodeServiceFactory;
use iRESTful\Outputs\Infrastructure\Services\FileCodeService;

final class FileCodeServiceFactory implements CodeServiceFactory {

    public function __construct() {

    }

    public function create() {
        return new FileCodeService();
    }

}
