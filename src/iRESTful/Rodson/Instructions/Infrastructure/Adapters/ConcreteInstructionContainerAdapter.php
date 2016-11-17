<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\ContainerAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionContainer;

final class ConcreteInstructionContainerAdapter implements ContainerAdapter {
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

        $isLoopContainer = false;
        if (strpos($string, '$each->container') !== false) {
            $isLoopContainer = true;
        }

        $value = null;
        $annotatedEntity = $getAnnotatedEntityByObjectName($string);
        if (empty($annotatedEntity) && empty($isLoopContainer)) {
            $value = $this->valueAdapter->fromStringToValue($string);
        }

        return new ConcreteInstructionContainer($isLoopContainer, $value, $annotatedEntity);
    }

}
