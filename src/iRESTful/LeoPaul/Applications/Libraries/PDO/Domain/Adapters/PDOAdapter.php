<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;

interface PDOAdapter {
    public function fromDataToPDO(array $data);
    public function fromPDOToNativePDOStatement(PDO $pdo);
}
