<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Outputs\Templates\Template;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCode;
use iRESTful\Rodson\Domain\Middles\Classes\SpecificClass;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\AnnotatedObject;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\AnnotatedEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Test;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Transform;
use iRESTful\Rodson\Domain\Outputs\Codes\Exceptions\CodeException;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Adapter;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    private $template;
    public function __construct(PathAdapter $pathAdapter, Template $template) {
        $this->pathAdapter = $pathAdapter;
        $this->template = $template;
    }

    public function fromClassesToCode(array $classes) {
        $output = [];
        foreach($classes as $index => $oneClass) {
            $codes = $this->fromClassToCodes($oneClass);
            $output = array_merge($output, $codes);
        }

        return $output;
    }

    private function fromClassToCodes(SpecificClass $class) {

        if ($class->hasAnnotatedObject()) {
            $annotatedObject = $class->getAnnotatedObject();
            return [
                $this->fromAnnotatedObjectToCode($annotatedObject)
            ];
        }

        if ($class->hasAnnotatedEntity()) {
            $annotatedEntity = $class->getAnnotatedEntity();
            return [
                $this->fromAnnotatedEntityToCode($annotatedEntity)
            ];
        }

        if ($class->hasValue()) {
            $value = $class->getValue();
            return $this->fromValueToCodes($value);
        }

        if ($class->hasController()) {
            $controller = $class->getController();
            return [
                $this->fromControllerToCode($controller)
            ];
        }

        if ($class->hasTest()) {
            $test = $class->getTest();
            return $this->fromTestToCodes($test);
        }

        throw new CodeException('The was no class in the Class object.');

    }

    private function fromTestToCodes(Test $test) {

        if ($test->hasTransform()) {
            $transform = $test->getTransform();
            return $this->fromTestTransformToCodes($transform);
        }

        throw new CodeException('The was no test in the Test object.');

    }

    private function fromTestTransformToCodes(Transform $transform) {
        $data = $transform->getData();
        $namespace = $transform->getNamespace();
        $configuration = $transform->getConfiguration();

        return [
            $this->fromConfigurationToCode($configuration),
            $this->render($namespace, $data, 'class.test.transform.php')
        ];
    }

    private function fromControllerToCode(Controller $controller) {
        $data = $controller->getData();
        $namespace = $controller->getNamespace();
        return $this->render($namespace, $data, 'class.controller.php');
    }

    private function fromValueToCodes(Value $value) {
        $data = $value->getData();
        $namespace = $value->getNamespace();
        $adapter = $value->getAdapter();

        return [
            $this->fromAdapterToCode($adapter),
            $this->render($namespace, $data, 'class.value.php')
        ];
    }

    private function fromAdapterToCode(Adapter $adapter) {
        $data = $adapter->getData();
        $namespace = $adapter->getNamespace();
        return $this->render($namespace, $data, 'class.adapter.php');
    }

    private function fromAnnotatedEntityToCode(AnnotatedEntity $annotatedEntity) {
        $data = $annotatedEntity->getData();
        $namespace = $annotatedEntity->getEntity()->getNamespace();
        return $this->render($namespace, $data, 'class.entity.php');
    }

    private function fromAnnotatedObjectToCode(AnnotatedObject $annotatedObject) {
        $data = $annotatedObject->getData();
        $namespace = $annotatedObject->getObject()->getNamespace();
        return $this->render($namespace, $data, 'class.object.php');
    }

    private function fromConfigurationToCode(Configuration $configuration) {
        $data = $configuration->getData();
        $namespace = $configuration->getNamespace();
        return $this->render($namespace, $data, 'class.configuration.php');
    }

    private function render(ClassNamespace $namespace, array $data, $templateFile) {
        $code = $this->template->render($templateFile, $data);

        $relativeFilePath = implode('/', $namespace->getAll()).'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

}
