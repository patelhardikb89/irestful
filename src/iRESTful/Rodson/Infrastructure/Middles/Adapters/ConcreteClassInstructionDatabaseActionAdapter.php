<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\ActionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Exceptions\ActionException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters\InsertAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\UpdateAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\DeleteAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseAction;

final class ConcreteClassInstructionDatabaseActionAdapter implements ActionAdapter {
    private $insertAdapter;
    private $updateAdapter;
    private $deleteAdapter;
    private $httpRequests;
    public function __construct(
        InsertAdapter $insertAdapter,
        UpdateAdapter $updateAdapter,
        DeleteAdapter $deleteAdapter,
        array $httpRequests = null
    ) {

        if (empty($httpRequests)) {
            $httpRequests = [];
        }

        $this->insertAdapter = $insertAdapter;
        $this->updateAdapter = $updateAdapter;
        $this->deleteAdapter = $deleteAdapter;
        $this->httpRequests = $httpRequests;
    }

    public function fromStringToAction($string) {

        if (strpos($string, 'execute ') === 0) {
            $keyname = substr($string, strlen('execute '));
            if (!isset($this->httpRequests[$keyname])) {
                throw new ActionException('There is an action instruction ('.$string.') that reference an invalid HttpRequest ('.$keyname.').');
            }

            return new ConcreteClassInstructionDatabaseAction($this->httpRequests[$keyname]);
        }
        
        if (strpos($string, 'insert ') === 0) {
            $command = substr($string, strlen('insert '));
            $insert = $this->insertAdapter->fromStringToInsert($command);
            return new ConcreteClassInstructionDatabaseAction(null, $insert);
        }

        if (strpos($string, 'update ') === 0) {
            $command = substr($string, strlen('update '));
            $update = $this->updateAdapter->fromStringToUpdate($command);
            return new ConcreteClassInstructionDatabaseAction(null, null, $update);
        }

        if (strpos($string, 'delete ') === 0) {
            $command = substr($string, strlen('delete '));
            $delete = $this->deleteAdapter->fromStringToDelete($command);
            return new ConcreteClassInstructionDatabaseAction(null, null, null, $delete);
        }

        throw new ActionException('The given action command ('.$string.') is invalid.');
    }

}
