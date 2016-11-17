<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Factories;
use iRESTful\Rodson\Outputs\Domain\Codes\Services\Factories\CodeServiceFactory;
use iRESTful\Rodson\Outputs\Infrastructure\Services\FileCodeService;

final class FileCodeServiceFactory implements CodeServiceFactory {

    public function __construct() {

    }

    public function create() {
        return new FileCodeService();
    }

}
