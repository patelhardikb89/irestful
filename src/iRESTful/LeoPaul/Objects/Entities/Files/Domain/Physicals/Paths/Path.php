<?php
namespace iRESTful\LeoPaul\Objects\Entities\Files\Domain\Physicals\Paths;

interface Path {
	public function get();
	public function getRelative();
	public function getFileName();
	public function getDirectories();
	public function getUrl();
	public function hasExtension();
	public function getExtension();
}
