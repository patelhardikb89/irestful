<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Applications;
use iRESTful\LeoPaul\Objects\Entities\Files\Applications\ImageApplication;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Adapters\DimensionAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteImage;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Resized\Services\ResizedImageService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Adapters\FileAdapter;

final class ConcreteImageApplication implements ImageApplication {
	private $resizedImageService;
	private $service;
	private $repository;
	private $criteriaAdapter;
	private $fileAdapter;
	private $dimensionAdapter;
	private $uuidFactory;
	private $dateTimeAdapter;
    public function __construct(ResizedImageService $resizedImageService, EntityService $service, EntityRepository $repository, EntityRetrieverCriteriaAdapter $criteriaAdapter, FileAdapter $fileAdapter, DimensionAdapter $dimensionAdapter, UuidFactory $uuidFactory, DateTimeAdapter $dateTimeAdapter) {
		$this->resizedImageService = $resizedImageService;
		$this->service = $service;
		$this->repository = $repository;
		$this->criteriaAdapter = $criteriaAdapter;
		$this->fileAdapter = $fileAdapter;
		$this->dimensionAdapter = $dimensionAdapter;
		$this->uuidFactory = $uuidFactory;
		$this->dateTimeAdapter = $dateTimeAdapter;
    }

	public function convert(array $input) {

		if (!isset($input['file_uuid'])) {
			throw new \Exception('The file uuid is mandatory.');
		}

		//retrieve the file:
		$criteria = $this->criteriaAdapter->fromHumanReadableDataToRetrieverCriteria([
			'container' => 'files',
			'uuid' => $input['file_uuid']
		]);

		$file = $this->repository->retrieve($criteria);

		//get the dimension:
		$dimension = $this->fileAdapter->fromFileToDimension($file);

		//create the image file:
		$uuid = $this->uuidFactory->create();
		$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime(time());
		$image = new ConcreteImage($uuid, $createdOn, $file, $dimension);

		//save the image:
		$this->service->insert($image);

		return $image;
	}

	public function resize(array $input) {

		if (!isset($input['uuid'])) {
			throw new \Exception('The image uuid is mandatory.');
		}

		//retrieve the image:
		$criteria = $this->criteriaAdapter->fromHumanReadableDataToRetrieverCriteria([
			'container' => 'images',
			'uuid' => $input['uuid']
		]);

		$image = $this->repository->retrieve($criteria);
		$dimension = $image->getDimension();
		$input['original_dimension'] = [
			'width' => $dimension->getWidth(),
			'height' => $dimension->getHeight()
		];

		$newDimension = $this->dimensionAdapter->fromDataToDimension($input);
		return $this->resizedImageService->resize($image, $newDimension);

	}

	public function delete(array $input) {

		if (!isset($input['uuid'])) {
			throw new \Exception('The image uuid is mandatory.');
		}

		//retrieve the image:
		$criteria = $this->criteriaAdapter->fromHumanReadableDataToRetrieverCriteria([
			'container' => 'images',
			'uuid' => $input['uuid']
		]);

		$image = $this->repository->retrieve($criteria);

		//delete the image:
		$this->service->delete($image);

		return $image;
	}

}
