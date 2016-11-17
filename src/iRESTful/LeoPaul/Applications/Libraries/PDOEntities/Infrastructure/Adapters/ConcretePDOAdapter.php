<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Adapters\Adapters\EntityAdapterAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;

final class ConcretePDOAdapter implements PDOAdapter {
    private $entityAdapterAdapter;
    private $entityAdapter;
    private $entityRepository;
    private $entityRelationRepository;
    public function __construct(EntityAdapterAdapter $entityAdapterAdapter, EntityRepository $entityRepository, EntityRelationRepository $entityRelationRepository) {
        $this->entityAdapterAdapter = $entityAdapterAdapter;
        $this->entityRepository = $entityRepository;
        $this->entityRelationRepository = $entityRelationRepository;
        $this->entityAdapter = null;
    }

    private function init() {

        if (empty($this->entityAdapter)) {
            $this->entityAdapter = $this->entityAdapterAdapter->fromRepositoriesToEntityAdapter($this->entityRepository, $this->entityRelationRepository);
        }

    }

    public function fromPDOToEntity(PDO $pdo, $container) {

        $this->init();

        try {

            $results = $this->fromPDOToResults($pdo);
            if (empty($results)) {
                return null;
            }

            return $this->entityAdapter->fromDataToEntity([
                'container' => $container,
                'data' => $results
            ], false);

        } catch (EntityException $exception) {
            throw new PDOException('There was an exception while converting data to an Entity object.', $exception);
        }
    }

    public function fromPDOToEntities(PDO $pdo, $container) {

        $this->init();

        try {

            $results = $this->fromPDOToResults($pdo);
            if (empty($results)) {
                return null;
            }

            $output = [];
            foreach($results as $oneResult) {
                $output[] = [
                    'container' => $container,
                    'data' => $oneResult
                ];
            }

            return $this->entityAdapter->fromDataToEntities($output, false);

        } catch (EntityException $exception) {
            throw new PDOException('There was an exception while converting data to an Entity objects.', $exception);
        }
    }

    public function fromPDOToResults(PDO $pdo) {
        $microDateTimeClosure = $pdo->getMicroDateTimeClosure();
        if (!$microDateTimeClosure->hasResults()) {
            return null;
        }

        return $microDateTimeClosure->getResults();
    }

}
