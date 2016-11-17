<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Names\Adapters\NameAdapter;
use iRESTful\Rodson\DSLs\Domain\Names\Exceptions\NameException;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteName;

final class ConcreteNameAdapter implements NameAdapter {

    public function __construct() {

    }

    public function fromStringToName($string) {
        $exploded = explode('/', $string);
        if (count($exploded) != 2) {
            throw new NameException('The string ('.$string.') must only contain 1 forward slash (/) in order to convert it to a Name object.');
        }

        return new ConcreteName($exploded[1], $exploded[0]);
    }

}
