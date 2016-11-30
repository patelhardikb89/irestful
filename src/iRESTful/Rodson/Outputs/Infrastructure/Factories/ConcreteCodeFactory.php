<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Factories;
use iRESTful\Rodson\Outputs\Domain\Codes\Factories\CodeFactory;
use iRESTful\Rodson\Outputs\Domain\Codes\Paths\Adapters\PathAdapter;
use iRESTful\Rodson\Outputs\Domain\Templates\Template;
use iRESTful\Rodson\Outputs\Infrastructure\Objects\ConcreteOutputCode;

final class ConcreteCodeFactory implements CodeFactory {
    private $rootPathAdapter;
    private $template;
    public function __construct(PathAdapter $rootPathAdapter, Template $template) {
        $this->rootPathAdapter = $rootPathAdapter;
        $this->template = $template;
    }

    public function createGitIgnore() {
        $code = $this->template->render('.gitignore.twig');
        $path =  $this->rootPathAdapter->fromRelativePathStringToPath('.gitignore');
        return new ConcreteOutputCode($code, $path);
    }

}
