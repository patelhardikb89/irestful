<?php
namespace iRESTful\Outputs\Infrastructure\Adapters;
use  iRESTful\Outputs\Domain\Codes\Adapters\CodeAdapter;
use  iRESTful\Outputs\Domain\Templates\Template;
use  iRESTful\Outputs\Domain\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Outputs\Infrastructure\Objects\ConcreteOutputCode;
use iRESTful\Classes\Domain\SpecificClass;
use iRESTful\ClassesObjectsAnnotations\Domain\AnnotatedObject;
use iRESTful\ClassesEntitiesAnnotations\Domain\AnnotatedEntity;
use iRESTful\ClassesValues\Domain\Value;
use iRESTful\ClassesControllers\Domain\Controller;
use iRESTful\ClassesTests\Domain\Test;
use iRESTful\ClassesTests\Domain\Transforms\Transform;
use iRESTful\Outputs\Domain\Codes\Exceptions\CodeException;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\ClassesConverters\Domain\Converter;
use iRESTful\ConfigurationsComposers\Domain\Composer;
use iRESTful\ConfigurationsVagrants\Domain\VagrantFile;
use iRESTful\ConfigurationsNginx\Domain\Nginx;
use iRESTful\ConfigurationsPHPUnits\Domain\PHPUnit;
use iRESTful\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\ClassesConfigurations\Domain\Objects\ObjectConfiguration;
use iRESTful\ClassesConfigurations\Domain\Configuration;
use iRESTful\ClassesApplications\Domain\Application;
use iRESTful\ClassesInstallations\Domain\Installation;
use iRESTful\ClassesTests\Domain\Controllers\Controller as TestController;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $rootPathAdapter;
    private $classPathAdapter;
    private $indexPathAdapter;
    private $template;
    public function __construct(PathAdapter $rootPathAdapter, PathAdapter $classPathAdapter, PathAdapter $indexPathAdapter, Template $template) {
        $this->rootPathAdapter = $rootPathAdapter;
        $this->classPathAdapter = $classPathAdapter;
        $this->indexPathAdapter = $indexPathAdapter;
        $this->template = $template;
    }

    public function fromPHPUnitToCode(PHPUnit $phpunit) {
        $data = $this->getData($phpunit);
        $code = $this->template->render('phpunit.xml.dist.twig', $data);
        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('phpunit.xml.dist');
        return new ConcreteOutputCode($code, $path);
    }

    public function fromVagrantFileToCodes(VagrantFile $vagrantFile) {
        $data = $this->getData($vagrantFile);

        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('Vagrantfile');

        $basePath = $path->getBasePath();
        $nginxFileName = $vagrantFile->getNginx()->getName();
        $data['absolute_nginx_directory_path'] = '/'.implode('/', $basePath).'/conf/nginx';
        $data['absolute_phpfpm_directory_path'] = '/'.implode('/', $basePath).'/conf/php-fpm';

        $code = $this->template->render('vagrantfile.twig', $data);
        $nginx = $vagrantFile->getNginx();

        $phpfpmCode = $this->template->render('phpfpm-www.conf.twig', []);
        $phpFpmPath =  $this->rootPathAdapter->fromRelativePathStringToPath('conf/php-fpm/www.conf');

        return [
            new ConcreteOutputCode($code, $path),
            new ConcreteOutputCode($phpfpmCode, $phpFpmPath),
            $this->fromNginxToCode($nginx)
        ];
    }

    public function fromComposerToCode(Composer $composer) {
        $data = $this->getData($composer);
        $code = $this->template->render('composer.json.twig', $data);
        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('composer.json');
        return new ConcreteOutputCode($code, $path);
    }

    public function fromApplicationToCodes(Application $application) {
        $data = $this->getData($application);
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

    public function fromAnnotatedObjectsToCodes(array $annotatedObjects) {
        $output = [];
        foreach($annotatedObjects as $oneAnnotatedObject) {
            $codes = $this->fromAnnotatedObjectToCodes($oneAnnotatedObject);
            if (!empty($codes)) {
                $output = array_merge($output, $codes);
            }
        }

        return $output;
    }

    public function fromAnnotatedEntitiesToCodes(array $annotatedEntities) {
        $output = [];
        foreach($annotatedEntities as $oneAnnotatedEntity) {
            $codes = $this->fromAnnotatedEntityToCodes($oneAnnotatedEntity);
            if (!empty($codes)) {
                $output = array_merge($output, $codes);
            }
        }

        return $output;
    }

    public function fromValuesToCodes(array $values) {
        $output = [];
        foreach($values as $oneValue) {
            $codes = $this->fromValueToCodes($oneValue);
            if (!empty($codes)) {
                $output = array_merge($output, $codes);
            }
        }

        return $output;
    }

    public function fromControllersToCodes(array $controllers) {
        $output = [];
        foreach($controllers as $oneController) {
            $output[] = $this->fromControllerToCode($oneController);
        }

        return $output;
    }

    public function fromTestsToCodes(array $tests) {
        $output = [];
        foreach($tests as $oneTest) {
            $output[] = $this->fromTestToCode($oneTest);
        }

        return $output;
    }

    public function fromInstallationToCode(Installation $installation) {
        $data = $this->getData($installation);
        $namespace = $installation->getNamespace();
        return $this->render($namespace, $data, 'class.installation.php');
    }

    private function fromNginxToCode(Nginx $nginx) {
        $data = $this->getData($nginx);

        $fileName = $nginx->getName();
        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('myFile');
        $basePath = '/'.implode('/', $path->getBasePath());
        $nginxPath = '/'.implode('/', $nginx->getRoot()->getDirectoryPath());
        $data['absolute_directory_path'] = $basePath.$nginxPath;

        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('conf/nginx/'.$fileName);
        $code = $this->template->render('nginx.conf.twig', $data);
        return new ConcreteOutputCode($code, $path);
    }

    private function fromTestToCode(Test $test) {

        if ($test->hasTransform()) {
            $transform = $test->getTransform();
            return $this->fromTestTransformToCode($transform);
        }

        if ($test->hasController()) {
            $controller = $test->getController();
            return $this->fromTestControllerToCode($controller);
        }

        throw new CodeException('There was no test in the Test object.');

    }

    private function fromTestControllerToCode(TestController $controller) {
        $data = $this->getData($controller);
        $namespace = $controller->getNamespace();

        return $this->render($namespace, $data, 'class.test.controller.php');
    }

    private function fromTestTransformToCode(Transform $transform) {
        $data = $this->getData($transform);
        $namespace = $transform->getNamespace();

        return $this->render($namespace, $data, 'class.test.transform.php');
    }

    private function fromControllerToCode(Controller $controller) {
        $data = $this->getData($controller);
        $namespace = $controller->getNamespace();
        return $this->render($namespace, $data, 'class.controller.php');
    }

    private function fromValueToCodes(Value $value) {
        $data = $this->getData($value);
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
        $data = $this->getData($converter);
        $namespace = $converter->getNamespace();
        $interface = $converter->getInterface();

        return [
            $this->render($namespace, $data, 'class.adapter.php'),
            $this->fromInterfaceToCode($interface)
        ];
    }

    private function fromAnnotatedEntityToCodes(AnnotatedEntity $annotatedEntity) {
        $data = $this->getData($annotatedEntity);
        $entity = $annotatedEntity->getEntity();
        $namespace = $entity->getNamespace();
        $interface = $entity->getInterface();

        return [
            $this->render($namespace, $data, 'class.entity.php'),
            $this->fromInterfaceToCode($interface)
        ];
    }

    private function fromAnnotatedObjectToCodes(AnnotatedObject $annotatedObject) {
        $data = $this->getData($annotatedObject);
        $object = $annotatedObject->getObject();
        $namespace = $object->getNamespace();
        $interface = $object->getInterface();

        return [
             $this->render($namespace, $data, 'class.object.php'),
             $this->fromInterfaceToCode($interface)
        ];

    }

    private function fromConfigurationToCodes(Configuration $configuration) {
        $data = $this->getData($configuration);
        $objectConfiguration = $configuration->getObjectConfiguration();
        $namespace = $configuration->getNamespace();

        return [
            $this->fromObjectConfigurationToCode($objectConfiguration),
            $this->render($namespace, $data, 'class.configuration.php')
        ];
    }

    private function fromObjectConfigurationToCode(ObjectConfiguration $configuration) {
        $data = $this->getData($configuration);
        $namespace = $configuration->getNamespace();
        return $this->render($namespace, $data, 'class.configuration.objects.php');
    }

    private function fromInterfaceToCode(ClassInterface $interface) {
        $data = $this->getData($interface);
        $namespace = $interface->getNamespace();
        return $this->render($namespace, $data, 'interface.php');
    }

    private function render(ClassNamespace $namespace, array $data, $templateFile) {
        $code = $this->template->render($templateFile, $data);

        $relativeFilePath = implode('/', $namespace->getAll()).'.php';
        $path = $this->classPathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

    private function renderIndex(array $data, $templateFile) {
        $code = $this->template->render($templateFile, $data);
        $path = $this->indexPathAdapter->fromRelativePathStringToPath('index.php');
        return new ConcreteOutputCode($code, $path);
    }

    private function getData($object) {

        $convert = function($name) {
            $output = '';
            $amount = strlen($name);
            for($i = 0; $i < $amount; $i++) {
                $char = substr($name, $i, 1);
                if (ctype_upper($char)) {
                    $output .= '_'.strtolower($char);
                    continue;
                }

                $output .= $char;
            }

            return $output;
        };

        $getFromArray = function(array $data) use(&$getFromArray) {
            foreach($data as $index => $oneValue) {

                if (is_object($oneValue)) {
                    $data[$index] = $this->getData($oneValue);
                    continue;
                }

                if (is_array($oneValue)) {
                    $data[$index] = $getFromArray($oneValue);
                    continue;
                }

                $data[$index] = $oneValue;

            }

            return $data;
        };

        $output = [];
        $class = new \ReflectionClass($object);
        $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);
        foreach($properties as $oneProperty) {

            $setAccessible = $oneProperty->isPrivate() || $oneProperty->isProtected();
            if ($setAccessible) {
                $oneProperty->setAccessible(true);
            }

            $name = $convert($oneProperty->getName());
            $value = $oneProperty->getValue($object);

            if ($setAccessible) {
                $oneProperty->setAccessible(true);
            }

            if (is_array($value)) {
                $value = $getFromArray($value);
            }

            if (is_object($value)) {
                $value = $this->getData($value);
            }

            if (!is_null($value)) {
                $output[$name] = $value;
            }
        }

        return $output;
    }

}
