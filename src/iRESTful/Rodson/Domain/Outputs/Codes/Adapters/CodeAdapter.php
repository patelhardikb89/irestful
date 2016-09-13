<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Composers\Composer;

interface CodeAdapter {
    public function fromClassesToCodes(array $classes);
    public function fromComposerToCode(Composer $composer);
}
