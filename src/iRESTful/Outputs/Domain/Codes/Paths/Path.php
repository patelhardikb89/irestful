<?php
namespace  iRESTful\Outputs\Domain\Codes\Paths;

interface Path {
    public function getPath();
    public function getRelativePath();
    public function getAbsolutePath();
    public function getBasePath();
    public function getFile();
}
