<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Paths;

interface Path {
    public function getPath();
    public function getRelativePath();
    public function getFile();
}
