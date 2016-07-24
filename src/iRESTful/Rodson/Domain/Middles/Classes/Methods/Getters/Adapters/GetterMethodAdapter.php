<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Methods\Getters\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Property;

interface GetterMethodAdapter {
    public function fromConstructorToGetterMethods(Constructor $constructor);
    public function fromPropertyToGetterMethod(Property $property);
}
