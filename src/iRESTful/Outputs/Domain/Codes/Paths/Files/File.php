<?php
namespace  iRESTful\Outputs\Domain\Codes\Paths\Files;

interface File {
    public function getName();
    public function hasExtension();
    public function getExtension();
    public function get();
}
