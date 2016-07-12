<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files;

interface File {
    public function getName();
    public function getExtension();
    public function get();
}
