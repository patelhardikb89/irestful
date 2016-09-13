<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths\Files;

interface File {
    public function getName();
    public function hasExtension();
    public function getExtension();
    public function get();
}
