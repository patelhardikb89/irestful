<?php
namespace  iRESTful\Rodson\Outputs\Domain\Codes\Paths;

interface Path {
    public function getPath();
    public function getRelativePath();
    public function getAbsolutePath();
    public function getFile();
}
