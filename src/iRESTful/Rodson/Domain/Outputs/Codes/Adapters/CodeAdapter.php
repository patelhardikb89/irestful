<?php
namespace iRESTful\Rodson\Domain\Outputs\Codes\Adapters;
use iRESTful\Rodson\Domain\Middles\Composers\Composer;
use iRESTful\Rodson\Domain\Middles\VagrantFiles\VagrantFile;
use iRESTful\Rodson\Domain\Middles\PHPUnits\PHPUnit;

interface CodeAdapter {
    public function fromClassesToCodes(array $classes);
    public function fromComposerToCode(Composer $composer);
    public function fromVagrantFileToCode(VagrantFile $vagrantFile);
    public function fromPHPUnitToCode(PHPUnit $phpunit);
}
