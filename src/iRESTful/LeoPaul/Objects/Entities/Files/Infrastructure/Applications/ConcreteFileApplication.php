<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Applications;
use iRESTful\LeoPaul\Objects\Entities\Files\Applications\FileApplication;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Chunks\Services\ChunkService;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFileChunk;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Services\FileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;

final class ConcreteFileApplication implements FileApplication {
	private $chunkService;
	private $dateTimeAdapter;
	private $uuidFactory;
	private $physicalPathAdapter;
	private $uuidAdapter;
	private $repository;
	private $service;
	private $entityRetrieverCriteriaAdapter;
	private $basePath;
	private $saveTo;
	public function __construct(ChunkService $chunkService, DateTimeAdapter $dateTimeAdapter, UuidFactory $uuidFactory, PhysicalFileAdapter $physicalPathAdapter, UuidAdapter $uuidAdapter, EntityRepository $repository, EntityRetrieverCriteriaAdapter $entityRetrieverCriteriaAdapter, FileService $service, $basePath, $saveTo) {
		$this->chunkService = $chunkService;
		$this->dateTimeAdapter = $dateTimeAdapter;
		$this->uuidFactory = $uuidFactory;
		$this->physicalPathAdapter = $physicalPathAdapter;
		$this->uuidAdapter = $uuidAdapter;
		$this->repository = $repository;
		$this->entityRetrieverCriteriaAdapter = $entityRetrieverCriteriaAdapter;
		$this->service = $service;
		$this->basePath = $basePath;
		$this->saveTo = $saveTo;
	}

	public function upload(array $input) {

		if (!isset($input['file'])) {
            throw new \Exception('The file is mandatory.');
        }

		if (!is_object($input['file']) || (!($input['file'] instanceof \Zend\Diactoros\UploadedFile))) {
			throw new \Exception('The file index must be an uploaded File object.');
		}

		$index = 0;
		$amount = 1;
		$futureFileUuid = $this->uuidFactory->create();
		if (isset($input['index']) && isset($input['future_file_uuid'])) {
			$index = $input['index'];
			$amount = $input['amount'];
			$futureFileUuid = $this->uuidAdapter->fromHumanReadableStringToUuid($input['future_file_uuid']);
		}

		$relativeFilePath = $this->saveTo.'/'.$futureFileUuid->getHumanReadable().'-'.$index.'-of-'.$amount;
		$filePath = $this->basePath.$relativeFilePath;
		$input['file']->moveTo($filePath);

		$uuid = $this->uuidFactory->create();
		$timestamp = time();
		$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime($timestamp);
		$physicalFile = $this->physicalPathAdapter->fromRelativePathStringToPhysicalFile($relativeFilePath);

		$chunk = new ConcreteFileChunk($uuid, $createdOn, $physicalFile, $futureFileUuid, $index);
		$savedChunk = $this->chunkService->insert($chunk);

		if (($index + 1) >= $amount) {
			$fileUuid = $savedChunk->getFutureFileUuid();
			$file = $this->service->insert($fileUuid);
			return $savedChunk->attachFile($file);
		}

		return $savedChunk;
	}

	public function delete(array $input) {

		if (!isset($input['uuid'])) {
			throw new \Exception('The uuid is mandatory.');
		}

		//retrieve the file:
		$criteria = $this->entityRetrieverCriteriaAdapter->fromHumanReadableDataToRetrieverCriteria([
			'container' => 'files',
			'uuid' => $input['uuid']
		]);

		$file = $this->repository->retrieve($criteria);

		//delete the file:
		$this->service->delete($file);

		//delete the chunks:
		$chunks = $file->getChunks();
		foreach($chunks as $oneChunk) {
			$this->chunkService->delete($oneChunk);
		}

		//return the deleted file:
		return $file;

	}

}
