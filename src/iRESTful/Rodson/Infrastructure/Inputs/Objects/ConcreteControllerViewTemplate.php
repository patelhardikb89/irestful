<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Templates\Template;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Views\Templates\Exceptions\TemplateException;

final class ConcreteControllerViewTemplate implements Template {
    private $path;
    private $processorKeyname;
    public function __construct($path, $processorKeyname) {

        if (empty($path) || !is_string($path)) {
            throw new TemplateException('The path must be a non-empty string.');
        }

        if (empty($processorKeyname) || !is_string($processorKeyname)) {
            throw new TemplateException('The processorKeyname must be a non-empty string.');
        }

        if (!is_dir($path)) {
            throw new TemplateException('The path ('.$path.') is not a valid directory.');
        }

        $this->path = $path;
        $this->processorKeyname = $processorKeyname;

    }

    public function getPath() {
        return $this->path;
    }

    public function getProcessorKeyname() {
        return $this->processorKeyname;
    }

}
