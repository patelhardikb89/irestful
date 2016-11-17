<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Templates\Template;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Views\Templates\Exceptions\TemplateException;

final class ConcreteControllerViewTemplate implements Template {
    private $path;
    private $processorKeyname;
    public function __construct(string $path, string $processorKeyname) {

        if (empty($processorKeyname)) {
            throw new TemplateException('The processorKeyname must be a non-empty string.');
        }

        if (!is_dir($path)) {
            throw new TemplateException('The path ('.$path.') is not a valid directory.');
        }

        $this->path = $path;
        $this->processorKeyname = $processorKeyname;

    }

    public function getPath(): string {
        return $this->path;
    }

    public function getProcessorKeyname(): string {
        return $this->processorKeyname;
    }

}
