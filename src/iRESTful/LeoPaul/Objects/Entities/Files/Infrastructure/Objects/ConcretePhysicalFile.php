<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\PhysicalFile;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths\Path;
use iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Exceptions\PhysicalFileException;

final class ConcretePhysicalFile implements PhysicalFile {
	private $path;
	private $content;
	public function __construct(Path $path = null, $content = null) {

		if (empty($content)) {
			$content = null;
		}

		$amount = (empty($path) ? 0 : 1) + (empty($content) ? 0 : 1);
		if ($amount != 1) {
			$word = ($amount > 1) ? 'Both' : 'None';
			throw new PhysicalFileException('There must be either path or content.  '.$word.' given.');
		}

		$this->path = $path;
		$this->content = $content;
	}

	public function hasPath() {
		return !empty($this->path);
	}

	public function getPath() {
		return $this->path;
	}

	public function hasContent() {
		return !empty($this->content);
	}

	public function getContent() {
		return$this->content;
	}

}
