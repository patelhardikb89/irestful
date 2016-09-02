<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Adapters;
use iRESTful\Rodson\Domain\Outputs\Codes\Adapters\CodeAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Tests\Functionals\Transforms\TransformTest;
use iRESTful\Rodson\Domain\Outputs\Templates\Template;
use iRESTful\Rodson\Domain\Outputs\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\ConcreteOutputCode;

final class ConcreteCodeAdapter implements CodeAdapter {
    private $pathAdapter;
    private $template;
    public function __construct(PathAdapter $pathAdapter, Template $template) {
        $this->pathAdapter = $pathAdapter;
        $this->template = $template;
    }

    public function fromConfigurationToCode(Configuration $configuration) {
        $data = $configuration->getData();
        $code = $this->template->render('configuration.php', $data);

        $relativeFilePath = implode('/', $configuration->getNamespace()->getAll()).'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);

    }

    public function fromAnnotatedClassToCodes(AnnotatedClass $annotatedClass) {

        $getTemplateFile = function() use(&$annotatedClass) {
            $class = $annotatedClass->getClass();
            if ($class->hasInstructions()) {
                return 'class.controller.php';
            }

            if ($class->getInterface()->isEntity()) {
                return 'class.entity.php';
            }

            return 'class.php';
        };

        $data = $annotatedClass->getData();
        $code = $this->template->render($getTemplateFile(), $data);

        if ($getTemplateFile() == 'class.controller.php') {
            print_r([$data, $getTemplateFile(), 66]);
            die();
        }

        $relativeFilePath = implode('/', $annotatedClass->getClass()->getNamespace()->getAll()).'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

    public function fromAnotatedClassesToCodes(array $annotatedClasses) {
        $output = [];
        foreach($annotatedClasses as $oneAnnotatedClass) {
            $output[] = $this->fromAnnotatedClassToCodes($oneAnnotatedClass);
        }

        return $output;
    }

    public function fromFunctionalTransformTestToCode(TransformTest $functionalTransformTest) {
        $data = $functionalTransformTest->getData();
        $code = $this->template->render('functional_transform_test.php', $data);

        $relativeFilePath = implode('/', $functionalTransformTest->getNamespace()->getAll()).'.php';
        $path = $this->pathAdapter->fromRelativePathStringToPath($relativeFilePath);

        return new ConcreteOutputCode($code, $path);
    }

    public function fromFunctionalTransformTestsToCodes(array $functionalTransformTests) {
        $output = [];
        foreach($functionalTransformTests as $oneFunctionalTransformTest) {
            $output[] = $this->fromFunctionalTransformTestToCode($oneFunctionalTransformTest);
        }

        return $output;
    }

}
