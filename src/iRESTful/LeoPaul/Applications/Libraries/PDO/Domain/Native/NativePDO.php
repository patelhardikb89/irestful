<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native;

interface NativePDO {
    public function getPDO();
    public function getDriver();
    public function getHostName();
    public function getUsername();
    public function getDatabase();
}
