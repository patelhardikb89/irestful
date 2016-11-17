<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;

interface ServerAdapter {
    public function fromNativePDOToServer(NativePDO $nativePDO);
}
