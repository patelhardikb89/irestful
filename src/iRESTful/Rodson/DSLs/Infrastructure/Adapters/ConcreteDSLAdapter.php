<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Adapters\DSLAdapter;
use iRESTful\Rodson\DSLs\Domain\Authors\Adapters\AuthorAdapter;
use iRESTful\Rodson\DSLs\Domain\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\DSLs\Domain\Exceptions\DSLException;
use iRESTful\Rodson\DSLs\Domain\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteDSL;
use iRESTful\Rodson\DSLs\Domain\Names\Adapters\NameAdapter;

final class ConcreteDSLAdapter implements DSLAdapter {
    private $nameAdapter;
    private $authorAdapter;
    private $urlAdapter;
    private $projectAdapter;
    public function __construct(
        NameAdapter $nameAdapter,
        AuthorAdapter $authorAdapter,
        UrlAdapter $urlAdapter,
        ProjectAdapter $projectAdapter
    ) {
        $this->nameAdapter = $nameAdapter;
        $this->authorAdapter = $authorAdapter;
        $this->urlAdapter = $urlAdapter;
        $this->projectAdapter = $projectAdapter;
    }

    public function fromDataToDSL(array $data) {

        if (!isset($data['name'])) {
            throw new DSLException('The name keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['type'])) {
            throw new DSLException('The type keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['urls'])) {
            throw new DSLException('The urls keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['license'])) {
            throw new DSLException('The license keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['authors'])) {
            throw new DSLException('The authors keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['maintainer'])) {
            throw new DSLException('The maintainer keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['project'])) {
            throw new DSLException('The project keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['version'])) {
            throw new DSLException('The version keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['base_directory'])) {
            throw new DSLException('The base_directory keyname is mandatory in order to convert data to a Rodson object.');
        }

        $name = $this->nameAdapter->fromStringToName($data['name']);
        $authors = $this->authorAdapter->fromDataToAuthors($data['authors']);
        $urls = $this->urlAdapter->fromDataToUrl($data['urls']);

        $data['project']['base_directory'] = $data['base_directory'];
        $project = $this->projectAdapter->fromDataToProject($data['project']);

        if (!isset($authors[$data['maintainer']])) {
            throw new DSLException('The given maintainer ('.$data['maintainer'].') is not an author.');
        }

        return new ConcreteDSL($name, $data['type'], $urls, $data['license'], $authors, $authors[$data['maintainer']], $project, $data['version']);

    }

}
