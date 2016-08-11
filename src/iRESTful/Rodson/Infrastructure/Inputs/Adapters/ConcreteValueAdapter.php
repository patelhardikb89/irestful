<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteValue;
use iRESTful\Rodson\Domain\Inputs\Values\Exceptions\ValueException;

final class ConcreteValueAdapter implements ValueAdapter {
    private $constants;
    public function __construct(array $constants) {
        $this->constants = $constants;
    }

    public function fromDataToValues(array $data) {
        $output = [];
        foreach($data as $keyname => $value) {
            $output[$keyname] = $this->fromStringToValue($value);
        }

        return $output;
    }

    public function fromStringToValue($string) {

        $pos = strpos($string, '->');
        if ($pos !== false) {
            $prefix = substr($string, 0, $pos);
            $name = substr($string, $pos + 2);
            if ($prefix == 'constants') {

                if (!isset($this->constants[$prefix])) {
                    throw new ValueException('The given constant ('.$prefix.') is not valid.');
                }

                return new ConcreteValue(null, null, $this->constants[$prefix]);

            }

            $variableName = substr($string, $pos + 2);
            return new ConcreteValue($variableName);
        }

        $matches = [];
        preg_match_all('/\[([a-z\_]+)\]/s', $string, $matches);
        if (isset($matches[1][0]) && !empty($matches[1][0])) {
            return new ConcreteValue(null, strtoupper($matches[1][0]));
        }

        return new ConcreteValue(null, null, $string);

    }

}
