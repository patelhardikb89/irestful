<?php
namespace  iRESTful\Rodson\Outputs\Domain\Codes\Adapters;
use iRESTful\Rodson\ConfigurationsComposers\Domain\Composer;
use iRESTful\Rodson\ConfigurationsVagrants\Domain\VagrantFile;
use iRESTful\Rodson\ConfigurationsPHPUnits\Domain\PHPUnit;
use iRESTful\Rodson\ClassesApplications\Domain\Application;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;
use iRESTful\Rodson\ConfigurationsDockerFiles\Domain\DockerFile;

interface CodeAdapter {
    public function fromComposerToCode(Composer $composer);
    public function fromDockerFileToCode(DockerFile $dockerFile);
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
