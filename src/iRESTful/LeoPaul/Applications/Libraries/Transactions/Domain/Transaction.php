<?php
namespace iRESTful\LeoPaul\Applications\Libraries\Transactions\Domain;

interface Transaction {
    public function execute(\Closure $closure);
}
