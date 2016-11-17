<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class ConcreteSubEntities implements SubEntities {
    private $existingEntities;
    private $newEntities;
    public function __construct(array $existingEntities = null, array $newEntities = null) {

        if (empty($existingEntities)) {
            $existingEntities = [];
        }

        if (empty($newEntities)) {
            $newEntities = [];
        }

        $this->existingEntities = $existingEntities;
        $this->newEntities = $newEntities;

    }

    public function hasExistingEntities() {
        return !empty($this->existingEntities);
    }

    public function getExistingEntities() {
        return $this->existingEntities;
    }

    public function hasNewEntities() {
        return !empty($this->newEntities);
    }

    public function getNewEntities() {
        return $this->newEntities;
    }

    public function getNewEntityIndex(Entity $entity) {
        return $this->getIndex($this->newEntities, $entity);
    }

    public function getExistingEntityIndex(Entity $entity) {
        return $this->getIndex($this->existingEntities, $entity);
    }

    public function merge(SubEntities $subEntities) {

        if ($subEntities->hasExistingEntities()) {
            $existings = $subEntities->getExistingEntities();
            foreach($existings as $oneExisting) {

                $index = $this->getExistingEntityIndex($oneExisting);
                if (is_null($index)) {
                    $this->existingEntities[] = $oneExisting;
                }

            }
        }

        if ($subEntities->hasNewEntities()) {
            $news = $subEntities->getNewEntities();
            foreach($news as $oneNew) {

                $index = $this->getNewEntityIndex($oneNew);
                if (is_null($index)) {
                    $this->newEntities[] = $oneNew;
                }

            }
        }

        return $this;
    }

    public function delete(SubEntities $subEntities) {

        if ($subEntities->hasExistingEntities()) {
            $existings = $subEntities->getExistingEntities();
            foreach($existings as $oneExisting) {
                $index = $this->getExistingEntityIndex($oneExisting);
                if (!is_null($index)) {
                    unset($this->existingEntities[$index]);
                    $this->existingEntities = array_values($this->existingEntities);
                }

            }
        }

        if ($subEntities->hasNewEntities()) {
            $news = $subEntities->getNewEntities();
            foreach($news as $oneNew) {
                $index = $this->getNewEntityIndex($oneNew);
                if (!is_null($index)) {
                    unset($this->newEntities[$index]);
                    $this->newEntities = array_values($this->newEntities);
                }

            }
        }

        return $this;

    }

    private function getIndex(array $entities, Entity $entity) {
        foreach($entities as $index => $oneEntity) {
            if ($oneEntity == $entity) {
                return $index;
            }
        }

        return null;
    }

}
