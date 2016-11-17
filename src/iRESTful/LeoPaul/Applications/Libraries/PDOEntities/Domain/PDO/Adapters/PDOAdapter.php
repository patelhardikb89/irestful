<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;

interface PDOAdapter {
    public function fromPDOToEntity(PDO $pdo, $container);
    public function fromPDOToEntities(PDO $pdo, $container);
    public function fromPDOToResults(PDO $pdo);
}
