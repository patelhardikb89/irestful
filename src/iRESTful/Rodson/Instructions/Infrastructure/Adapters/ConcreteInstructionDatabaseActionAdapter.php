<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\ActionAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Exceptions\ActionException;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Inserts\Adapters\InsertAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Updates\Adapters\UpdateAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters\DeleteAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseAction;

final class ConcreteInstructionDatabaseActionAdapter implements ActionAdapter {
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

            return new ConcreteInstructionDatabaseAction($this->httpRequests[$keyname]);
        }

        if (strpos($string, 'insert ') === 0) {
            $command = substr($string, strlen('insert '));
            $insert = $this->insertAdapter->fromStringToInsert($command);
            return new ConcreteInstructionDatabaseAction(null, $insert);
        }

        if (strpos($string, 'update ') === 0) {
            $command = substr($string, strlen('update '));
            $update = $this->updateAdapter->fromStringToUpdate($command);
            return new ConcreteInstructionDatabaseAction(null, null, $update);
        }

        if (strpos($string, 'delete ') === 0) {
            $command = substr($string, strlen('delete '));
            $delete = $this->deleteAdapter->fromStringToDelete($command);
            return new ConcreteInstructionDatabaseAction(null, null, null, $delete);
        }

        throw new ActionException('The given action command ('.$string.') is invalid.');
    }

}
