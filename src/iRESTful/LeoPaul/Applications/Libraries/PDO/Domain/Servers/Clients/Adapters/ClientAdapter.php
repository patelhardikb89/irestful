<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients\Adapters;

interface ClientAdapter {
    public function fromNativePDOToClient(\PDO $pdo);
}
