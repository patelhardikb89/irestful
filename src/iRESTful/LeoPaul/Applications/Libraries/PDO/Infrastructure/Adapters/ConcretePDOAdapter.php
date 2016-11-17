<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Factories\ServerFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcretePDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Exceptions\MicroDateTimeClosureException;

final class ConcretePDOAdapter implements PDOAdapter {
    private $serverFactory;
    private $microDateTimeClosureAdapter;
    public function __construct(ServerFactory $serverFactory, MicroDateTimeClosureAdapter $microDateTimeClosureAdapter) {
        $this->serverFactory = $serverFactory;
        $this->microDateTimeClosureAdapter = $microDateTimeClosureAdapter;
    }

    public function fromDataToPDO(array $data) {

        if (!isset($data['closure'])) {
            throw new PDOException('The closure keyname is mandatory in order to convert data to a PDO object.');
        }

        if (!($data['closure'] instanceof \Closure)) {
            throw new PDOException('The closure keyname must contain a \Closure object.');
        }

        try {

            $request = null;
            if (isset($data['request'])) {

                if (!($data['request'] instanceof Request)) {
                    throw new PDOException('The closure keyname must contain a Request object if not null.');
                }

                $request = $data['request'];
            }

            $requests = null;
            if (isset($data['requests'])) {
                $requests = $data['requests'];
            }

            if (empty($request) && empty($requests)) {
                throw new PDOException('Either a request or requests keyname must be provided in order to convert data to a PDO object.');
            }

            $server = $this->serverFactory->create();
            $microDateTimeClosure = $this->microDateTimeClosureAdapter->fromClosureToMicroDateTimeClosure($data['closure']);
            return new ConcretePDO($microDateTimeClosure, $server, $request, $requests);

        } catch (ServerException $exception) {
            throw new PDOException('There was an exception while creating a Server object.', $exception);
        } catch (MicroDateTimeClosureException $exception) {
            throw new PDOException('There was an exception while converting a \Closure to a MicroDateTimeClosure object.', $exception);
        }

    }

    public function fromPDOToNativePDOStatement(PDO $pdo) {

        $microDateTimeClosure = $pdo->getMicroDateTimeClosure();
        if (!$microDateTimeClosure->hasResults()) {
            throw new PDOException('The PDO object must contain a MicroDateTimeClosure object that has results in order to have a \PDOStatement as results.');
        }

        $statement = $microDateTimeClosure->getResults();
        if (!($statement instanceof \PDOStatement)) {
            throw new PDOException('The results contained in the MicroDateTimeClosure object of the PDO object must be of type \PDOStatement in order to convert the PDO object to a \PDOStatement object.');
        }

        return $statement;
    }

}
