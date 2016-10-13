<?php
namespace iRESTful\Outputs\Infrastructure\Services;
use  iRESTful\Outputs\Domain\Codes\Services\CodeService;
use  iRESTful\Outputs\Domain\Codes\Code;

final class FileCodeService implements CodeService {

    public function __construct() {

    }

    public function saveMultiple(array $codes) {
        $output = [];
        foreach($codes as $oneCode) {
            $this->save($oneCode);
        }
    }

    public function save(Code $code) {

        $content = $code->getCode();
        $path = $code->getPath();

        //create directory if not already created:
        $absolutePath = '/'.implode('/', $path->getAbsolutePath());

        if (!is_dir($absolutePath)) {
            mkdir($absolutePath, 0777, true);
        }

        //write file:
        $filePath = '/'.implode('/', $path->getPath());
        file_put_contents($filePath, $content);

        if ($code->hasSubCodes()) {
            $subCodes = $code->getSubCodes();
            $this->saveMultiple($subCodes);
        }
    }

}
