<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionContainer;

final class ConcreteClassInstructionContainerAdapter implements ContainerAdapter {
    private $valueAdapter;
    private $annotatedEntities;
    public function __construct(ValueAdapter $valueAdapter, array $annotatedEntities) {
        $this->valueAdapter = $valueAdapter;
        $this->annotatedEntities = $annotatedEntities;
    }

    public function fromStringToContainer($string) {

        $annotatedEntities = $this->annotatedEntities;
        $getAnnotatedEntityByObjectName = function($objectName) use(&$annotatedEntities) {

            foreach($annotatedEntities as $oneAnnotatedEntity) {
                $object = $oneAnnotatedEntity->getEntity()->getObject();
                if ($object->getName() == $objectName) {
                    return $oneAnnotatedEntity;
                }
            }

            return null;

        };

        $value = null;
        $annotatedEntity = $getAnnotatedEntityByObjectName($string);
        if (empty($annotatedEntity)) {
            $value = $this->valueAdapter->fromStringToValue($string);
        }

        return new ConcreteClassInstructionContainer($value, $annotatedEntity);
    }

}
