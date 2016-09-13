<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Composers\Composer;
use iRESTful\Rodson\Domain\Middles\VagrantFiles\VagrantFile;

interface CodeAdapter {
    public function fromClassesToCodes(array $classes);
    public function fromComposerToCode(Composer $composer);
    public function fromVagrantFileToCode(VagrantFile $vagrantFile);
}
