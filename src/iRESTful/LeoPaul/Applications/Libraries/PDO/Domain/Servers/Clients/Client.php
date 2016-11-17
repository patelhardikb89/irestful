<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Clients;

interface Client {
    public function getVersion();
    public function connectedBy();
}
