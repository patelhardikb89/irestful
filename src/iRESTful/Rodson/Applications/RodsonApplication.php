<?php
namespace iRESTful\Rodson\Applications;

interface RodsonApplication {
    public function executeByFolder($folderPath, $outputFolderPath);
    public function executeByFile($filePath, $outputFolderPath);
}
