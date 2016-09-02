<?php
namespace iRESTful\Rodson\Domain\Middles\Namespaces\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Types\Type as PropertyType;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Action;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Retrieval;

interface NamespaceAdapter {
    public function fromRetrievalToNamespace(Retrieval $retrieval);
    public function fromConversionToNamespace(Conversion $conversion);
    public function fromActionToNamespace(Action $action);
    public function fromControllerToNamespace(Controller $controller);
    public function fromPropertyTypeToNamespace(PropertyType $propertyType);
    public function fromObjectToNamespace(Object $object);
    public function fromTypeToAdapterNamespace(Type $type);
    public function fromTypeToNamespace(Type $type);
}
