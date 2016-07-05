<?php
namespace iRESTful\Rodson\Infrastructure\Services;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Services\InterfaceService;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Interface;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;

final class FileInterfaceService implements InterfaceService {
    private $codeAdapter;
    private $namespace;
    public function __construct(CodeAdapter $codeAdapter, $baseFilePath) {
        $this->codeAdapter = $codeAdapter;
        $this->baseFilePath = $baseFilePath;
    }

    public function save(Interface $interface) {
        $code = $this->codeAdapter->fromInterfaceToCode();
        $content = $code->getCode();
        $filePath = $this->baseFilePath.'/'.$code->getRelativeFilePath();

        //must also create the directory structure on file.  Should create a file service.
        file_put_contents($filePath, $content);
    }

}
