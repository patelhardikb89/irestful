<?php
namespace iRESTful\Rodson\Domain;

interface Rodson {
    public function getName();
    public function hasParents();
    public function getParents();
    public function hasTypes();
    public function getTypes();
    public function hasAdapters();
    public function getAdapters();
    public function hasEntities();
    public function getEntities();
    public function hasViews();
    public function getViews();
    public function hasDatabases();
    public function getDatabases();
}
