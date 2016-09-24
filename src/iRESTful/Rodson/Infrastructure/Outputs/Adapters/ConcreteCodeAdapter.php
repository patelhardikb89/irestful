<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
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
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Converter;
use iRESTful\Rodson\Domain\Middles\Composers\Composer;
use iRESTful\Rodson\Domain\Middles\VagrantFiles\VagrantFile;
use iRESTful\Rodson\Domain\Middles\PHPUnits\PHPUnit;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Configurations\Objects\ObjectConfiguration;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Applications\Application;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    private $template;
    private $webBaseFolder;
    public function __construct(PathAdapter $pathAdapter, Template $template, $webBaseFolder) {
        $this->pathAdapter = $pathAdapter;
        $this->template = $template;
        $this->webBaseFolder = $webBaseFolder;
    }

    public function fromPHPUnitToCode(PHPUnit $phpunit) {
        $data = $phpunit->getData();
        $code = $this->template->render('phpunit.xml.dist.twig', $data);
        $path =  $this->pathAdapter->fromRelativePathStringToPath('phpunit.xml.dist');
        return new ConcreteOutputCode($code, $path);
    }

    public function fromVagrantFileToCode(VagrantFile $vagrantFile) {
        $data = $vagrantFile->getData();
        $code = $this->template->render('vagrantfile.twig', $data);
        $path =  $this->pathAdapter->fromRelativePathStringToPath('Vagrantfile');
        return new ConcreteOutputCode($code, $path);
    }

    public function fromComposerToCode(Composer $composer) {
        $data = $composer->getData();
        $code = $this->template->render('composer.json.twig', $data);
        $path =  $this->pathAdapter->fromRelativePathStringToPath('composer.json');
        return new ConcreteOutputCode($code, $path);
    }

    public function fromClassesToCodes(array $classes) {
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
            return $this->fromAnnotatedObjectToCodes($annotatedObject);
        }

        if ($class->hasAnnotatedEntity()) {
            $annotatedEntity = $class->getAnnotatedEntity();
            return $this->fromAnnotatedEntityToCodes($annotatedEntity);
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
            return [
                $this->fromTestToCode($test)
            ];
        }

        if ($class->hasApplication()) {
            $application = $class->getApplication();
            return $this->fromApplicationToCodes($application);
        }

        throw new CodeException('The was no class in the Class object.');

    }

    private function fromTestToCode(Test $test) {

        if ($test->hasTransform()) {
            $transform = $test->getTransform();
            return $this->fromTestTransformToCode($transform);
        }

        throw new CodeException('The was no test in the Test object.');

    }

    private function fromTestTransformToCode(Transform $transform) {
        $data = $transform->getData();
        $namespace = $transform->getNamespace();

        return $this->render($namespace, $data, 'class.test.transform.php');
    }

    private function fromControllerToCode(Controller $controller) {
        $data = $controller->getData();
        $namespace = $controller->getNamespace();
        return $this->render($namespace, $data, 'class.controller.php');
    }

    private function fromValueToCodes(Value $value) {
        $data = $value->getData();
        $namespace = $value->getNamespace();
        $converter = $value->getConverter();
        $interface = $value->getInterface();

        $codeConverters = $this->fromConverterToCodes($converter);
        return array_merge($codeConverters, [
            $this->render($namespace, $data, 'class.value.php'),
            $this->fromInterfaceToCode($interface)
        ]);
    }

    private function fromConverterToCodes(Converter $converter) {
        $data = $converter->getData();
        $namespace = $converter->getNamespace();
        $interface = $converter->getInterface();

        return [
            $this->render($namespace, $data, 'class.adapter.php'),
            $this->fromInterfaceToCode($interface)
        ];
    }

    private function fromAnnotatedEntityToCodes(AnnotatedEntity $annotatedEntity) {
        $data = $annotatedEntity->getData();
        $entity = $annotatedEntity->getEntity();
        $namespace = $entity->getNamespace();
        $interface = $entity->getInterface();
        return [
            $this->render($namespace, $data, 'class.entity.php'),
            $this->fromInterfaceToCode($interface)
        ];
    }

    private function fromAnnotatedObjectToCodes(AnnotatedObject $annotatedObject) {
        $data = $annotatedObject->getData();
        $object = $annotatedObject->getObject();
        $namespace = $object->getNamespace();
        $interface = $object->getInterface();

        return [
             $this->render($namespace, $data, 'class.object.php'),
             $this->fromInterfaceToCode($interface)
        ];

    }

    private function fromConfigurationToCodes(Configuration $configuration) {
        $data = $configuration->getData();
        $objectConfiguration = $configuration->getObjectConfiguration();
        $namespace = $configuration->getNamespace();

        return [
            $this->fromObjectConfigurationToCode($objectConfiguration),
            $this->render($namespace, $data, 'class.configuration.php')
        ];
    }

    private function fromApplicationToCodes(Application $application) {
        $data = $application->getData();
        $configuration = $application->getConfiguration();
        $namespace = $application->getNamespace();

        return array_merge(
            $this->fromConfigurationToCodes($configuration),
            [
                $this->render($namespace, $data, 'class.application.php'),
                $this->renderIndex($data, 'index.php')
            ]
        );
    }

    private function fromObjectConfigurationToCode(ObjectConfiguration $configuration) {
        $data = $configuration->getData();
        $namespace = $configuration->getNamespace();
        return $this->render($namespace, $data, 'class.configuration.objects.php');
    }

    private function fromInterfaceToCode(ClassInterface $interface) {
        $data = $interface->getData();
        $namespace = $interface->getNamespace();
        return $this->render($namespace, $data, 'interface.php');
    }

    private function render(ClassNamespace $namespace, array $data, $templateFile) {
        $code = $this->template->render($templateFile, $data);

        $relativeFilePath = implode('/', $namespace->getAll()).'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

    private function renderIndex(array $data, $templateFile) {
        $code = $this->template->render($templateFile, $data);

        $relativeFilePath = $this->webBaseFolder.'/index.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

}
