<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\EntityData;

final class ConcreteEntityData implements EntityData {
    private $container;
    private $data;
    public function __construct(string $container, array $data) {
        $this->container = $container;
        $this->data = $data;
    }

    public function getContainerName() {
        return $this->container;
    }

    public function getData() {
        return $this->data;
    }

}
