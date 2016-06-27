<?php
namespace iRESTful\Rodson\Domain\Types;

interface Type {
    public function getName();
    public function getDatabaseType();
    public function hasDatabaseAdapter();
    public function getDatabaseAdapter();
    public function hasViewAdapter();
    public function getViewAdapter();
    public function hasCode();
    public function getCode();
}
