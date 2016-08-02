<?php
namespace iRESTful\Rodson\Domain\Inputs\Types;

interface Type {
    public function getName();
    public function getDatabaseType();
    public function hasDatabaseAdapter();
    public function getDatabaseAdapter();
    public function getDatabaseAdapterMethodName();
    public function hasViewAdapter();
    public function getViewAdapter();
    public function getViewAdapterMethodName();
    public function hasMethod();
    public function getMethod();
}
