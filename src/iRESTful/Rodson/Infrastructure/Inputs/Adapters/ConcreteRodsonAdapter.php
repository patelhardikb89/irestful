<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Adapters\RodsonAdapter;
use iRESTful\Rodson\Domain\Inputs\Authors\Adapters\AuthorAdapter;
use iRESTful\Rodson\Domain\Inputs\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\Domain\Inputs\Exceptions\RodsonException;
use iRESTful\Rodson\Domain\Inputs\Projects\Adapters\ProjectAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteRodson;
use iRESTful\Rodson\Domain\Inputs\Names\Adapters\NameAdapter;

final class ConcreteRodsonAdapter implements RodsonAdapter {
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

    public function fromDataToRodson(array $data) {

        if (!isset($data['name'])) {
            throw new RodsonException('The name keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['type'])) {
            throw new RodsonException('The type keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['url'])) {
            throw new RodsonException('The url keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['license'])) {
            throw new RodsonException('The license keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['authors'])) {
            throw new RodsonException('The authors keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['project'])) {
            throw new RodsonException('The project keyname is mandatory in order to convert data to a Rodson object.');
        }

        if (!isset($data['base_directory'])) {
            throw new RodsonException('The base_directory keyname is mandatory in order to convert data to a Rodson object.');
        }

        $name = $this->nameAdapter->fromStringToName($data['name']);
        $authors = $this->authorAdapter->fromDataToAuthors($data['authors']);
        $url = $this->urlAdapter->fromStringToUrl($data['url']);

        $data['project']['base_directory'] = $data['base_directory'];
        $project = $this->projectAdapter->fromDataToProject($data['project']);

        return new ConcreteRodson($name, $data['type'], $url, $data['license'], $authors, $project);

    }

    public function fromDataToRodsons(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToRodson($oneData);
        }

        return $output;
    }

}
