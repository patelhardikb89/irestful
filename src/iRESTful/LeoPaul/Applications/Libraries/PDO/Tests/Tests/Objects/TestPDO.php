<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Objects;

class TestPDO extends \PDO {
    private $throwsException;
    public function __construct($throwsException = false) {
        $this->throwsException = $throwsException;
    }

    public function getAttribute($flag) {

        if ($this->throwsException) {
            throw new \PDOException('TEST');
        }

        if ($flag == \PDO::ATTR_CLIENT_VERSION) {
            return 'v1.2.3';
        }

        if ($flag == \PDO::ATTR_CONNECTION_STATUS) {
            return '127.0.0.1 by TCP/IP';
        }

        if ($flag == \PDO::ATTR_SERVER_INFO) {
            return 'lets say this is some stats.';
        }

        if ($flag == \PDO::ATTR_SERVER_VERSION) {
            return 'v12.11.22';
        }

        if ($flag == \PDO::ATTR_PERSISTENT) {
            return (int) false;
        }

        if ($flag == \PDO::ATTR_AUTOCOMMIT) {
            return (int) true;
        }

        return null;

    }

}
