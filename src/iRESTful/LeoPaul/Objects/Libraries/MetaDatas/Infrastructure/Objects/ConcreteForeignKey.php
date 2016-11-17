<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;

final class ConcreteForeignKey implements ForeignKey {
    private $reference;
    private $multiReference;
    public function __construct(Table $reference = null, Table $multiReference = null) {
        $this->reference = $reference;
        $this->multiReference = $multiReference;
    }

    public function hasTableReference() {
        return !empty($this->reference);
    }

    public function getTableReference() {
        return $this->reference;
    }

    public function hasMultiTableReference() {
        return !empty($this->multiReference);
    }

    public function getMultiTableReference() {
        return $this->multiReference;
    }

}
