<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers;

interface Server {
    public function getClient();
    public function getDriver();
    public function getHostname();
    public function getDatabase();
    public function getUsername();
    public function getStats();
    public function getVersion();
    public function isPersistent();
    public function isAutoCommit();
}
