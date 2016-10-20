<?php
namespace  iRESTful\Outputs\Domain\Codes\Adapters;
use iRESTful\ConfigurationsComposers\Domain\Composer;
use iRESTful\ConfigurationsVagrants\Domain\VagrantFile;
use iRESTful\ConfigurationsPHPUnits\Domain\PHPUnit;
use iRESTful\ClassesApplications\Domain\Application;
use iRESTful\ClassesInstallations\Domain\Installation;

interface CodeAdapter {
    public function fromComposerToCode(Composer $composer);
    public function fromVagrantFileToCodes(VagrantFile $vagrantFile);
    public function fromPHPUnitToCode(PHPUnit $phpunit);
    public function fromInstallationToCode(Installation $installation);
    public function fromTestsToCodes(array $tests);
    public function fromControllersToCodes(array $controllers);
    public function fromValuesToCodes(array $values);
    public function fromAnnotatedEntitiesToCodes(array $annotatedEntities);
    public function fromAnnotatedObjectsToCodes(array $annotatedObjects);
    public function fromApplicationToCodes(Application $application);
}
