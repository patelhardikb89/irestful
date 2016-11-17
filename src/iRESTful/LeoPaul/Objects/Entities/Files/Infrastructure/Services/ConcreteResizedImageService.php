<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Services;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Resized\Services\ResizedImageService;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Image;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Dimensions\Dimension;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Services\PhysicalFileService;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcretePhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects\ConcreteResizedImage;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Adapters\PhysicalFileAdapter;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Images\Adapters\ImageAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\UuidFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\DateTimeAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Services\EntityService;

final class ConcreteResizedImageService implements ResizedImageService {
	private $uuidFactory;
	private $dateTimeAdapter;
	private $physicalFileService;
	private $physicalFileAdapter;
	private $imageAdapter;
	private $entityService;
	public function __construct(UuidFactory $uuidFactory, DateTimeAdapter $dateTimeAdapter, PhysicalFileService $physicalFileService, PhysicalFileAdapter $physicalFileAdapter, ImageAdapter $imageAdapter, EntityService $entityService) {
		$this->uuidFactory = $uuidFactory;
		$this->dateTimeAdapter = $dateTimeAdapter;
		$this->physicalFileService = $physicalFileService;
		$this->physicalFileAdapter = $physicalFileAdapter;
		$this->imageAdapter = $imageAdapter;
		$this->entityService = $entityService;
	}

	public function resize(Image $originalImage, Dimension $newDimension) {

		try {
			
			//resize the copied file:
			$file = $originalImage->getFile();
			$width = $newDimension->getWidth();
			$height = $newDimension->getHeight();
			$path = $originalImage->getFile()->getPhysicalFile()->getPath()->get();
			$imagick = new \Imagick($path);
			if (!$imagick->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, false)) {
				throw new \Exception('There was a problem while resizing the image.');
			}

			$content = $imagick->getImageBlob();
			$physicalFile = $this->physicalFileAdapter->fromContentToPhysicalFile($content);
			$physicalFile = $this->physicalFileService->insert($physicalFile);

			//create the image & save it:
			$image = $this->imageAdapter->fromPhysicalFileToImage($physicalFile);
			$file = $image->getFile();
			$chunks = $file->getChunks();

			foreach($chunks as $oneChunk) {
				$this->entityService->insert($oneChunk);
			}

			$this->entityService->insert($file);
			$this->entityService->insert($image);

			//create the new ReziedImage object:
			$uuid = $this->uuidFactory->create();
			$createdOn = $this->dateTimeAdapter->fromTimestampToDateTime(time());
			$resizedImage = new ConcreteResizedImage($uuid, $createdOn, $image, $originalImage);

			//save the ReziedImage object:
			$this->entityService->insert($resizedImage);

			//retrun the EntityResizedImage object:
			return $resizedImage;

		} catch (\ImagickException $exception) {
			throw new \Exception('There was a problem while using Imagick.', $exception);
		}

	}

}
