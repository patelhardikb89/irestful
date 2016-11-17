<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Services\PhysicalFileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Services\FileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\File;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Services\Representations\FileRepresentation;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Multiples\MultipleEntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteFile;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;

final class ConcreteFileService implements FileService {
	private $dateTimeAdapter;
	private $multipleEntityRetrieverCriteriaAdapter;
	private $physicalFileService;
	private $physicalFileAdapter;
	private $entityService;
	private $entityRepository;
	public function __construct(DateTimeAdapter $dateTimeAdapter, MultipleEntityRetrieverCriteriaAdapter $multipleEntityRetrieverCriteriaAdapter, PhysicalFileService $physicalFileService, PhysicalFileAdapter $physicalFileAdapter, EntityService $entityService, EntityRepository $entityRepository) {
		$this->dateTimeAdapter = $dateTimeAdapter;
		$this->multipleEntityRetrieverCriteriaAdapter = $multipleEntityRetrieverCriteriaAdapter;
		$this->physicalFileService = $physicalFileService;
		$this->physicalFileAdapter = $physicalFileAdapter;
		$this->entityService = $entityService;
		$this->entityRepository = $entityRepository;
	}

	public function insert(Uuid $futureFileUuid) {

		//retrieve all the chunks
		$criteria = $this->multipleEntityRetrieverCriteriaAdapter->fromDataToMultipleRetrieverCriteria([
			'container' => 'file_chunks',
			'keyname' => [
				'name' => 'future_file_uuid',
				'value' => $futureFileUuid->get()
			],
			'ordering' => [
				'names' => [
					'file_index'
				]
			]
		]);

		$chunks = $this->entityRepository->retrieveMultiple($criteria);

		$content = '';
		foreach($chunks as $oneChunk) {
			$path = $oneChunk->getPhysicalFile()->getPath()->get();
			$content .= file_get_contents($path);
		}

		$file = $this->physicalFileAdapter->convertDataToPhysicalFile([
			'content' => $content
		]);

		$savedFile = $this->physicalFileService->insert($file);

		$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime(time());
		$path = $savedFile->getPath();
		$pathAsString = $path->get();

		$sizeInByte = filesize($pathAsString);
		$mimeType = mime_content_type($pathAsString);

		$file = new ConcreteFile($futureFileUuid, $createdOn, $savedFile, $chunks, $sizeInByte, $mimeType);
		$this->entityService->insert($file);
		return $file;
	}

	public function delete(File $file) {

		$path = $file->getPhysicalFile()->getPath();
		$this->physicalFileService->delete($path);

		return $this->entityService->delete($file);

	}

}
