<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\SubDSLs\Adapters\SubDSLAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\DSLs\Domain\SubDSLs\Exceptions\SubDSLException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteSubDSL;
use iRESTful\Rodson\DSLs\Domain\Adapters\DSLAdapter;

final class ConcreteSubDSLAdapter implements SubDSLAdapter {
    private $dslAdapter;
    private $databases;
    private $baseDirectory;
    public function __construct(DSLAdapter $dslAdapter, array $databases, $baseDirectory) {
        $this->dslAdapter = $dslAdapter;
        $this->databases = $databases;
        $this->baseDirectory = $baseDirectory;
    }

    public function fromDataToSubDSLs(array $data) {
        $output = [];
        foreach($data as $name => $oneData) {
            $oneData['name'] = $name;
            $output[$name] = $this->fromDataToSubDSL($oneData);
        }

        return $output;
    }

    public function fromDataToSubDSL(array $data) {

        if (!isset($data['file'])) {
            throw new SubDSLException('The file keyname is mandatory in order to convert data to a SubDSL.');
        }

        if (!isset($data['name'])) {
            throw new SubDSLException('The name keyname is mandatory in order to convert data to a SubDSL.');
        }

        if (!isset($data['database'])) {
            throw new SubDSLException('The database keyname is mandatory in order to convert data to a SubDSL.');
        }

        if (!isset($this->databases[$data['database']])) {
            throw new SubDSLException('The database name ('.$data['database'].') does not reference a valid database object.');
        }

        $filePath = $this->baseDirectory.'/'.$data['file'];
        if (!file_exists($filePath)) {
            throw new SubDSLException('The given file name ('.$filePath.') does not reference a valid file.');
        }

        $parentData = @json_decode(file_get_contents($filePath), true);
        if (empty($parentData)) {
            throw new SubDSLException('The given file name ('.$filePath.') is not a valid json file.');
        }

        $exploded = explode('/', $filePath);
        array_pop($exploded);

        $parentData['base_directory'] = implode('/', $exploded);
        $dsl = $this->dslAdapter->fromDataToDSL($parentData);
        return new ConcreteSubDSL($data['name'], $this->databases[$data['database']], $dsl);
    }

}
