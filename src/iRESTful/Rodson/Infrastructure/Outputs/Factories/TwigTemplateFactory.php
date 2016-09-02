<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Factories;
use iRESTful\Rodson\Domain\Outputs\Templates\Factories\TemplateFactory;
use iRESTful\Rodson\Domain\Outputs\Templates\Exceptions\TemplateException;
use iRESTful\Rodson\Infrastructure\Outputs\Objects\TwigTemplate;

final class TwigTemplateFactory implements TemplateFactory {
    private $templateFolder;
    private $cacheFolder;
    public function __construct($templateFolder, $cacheFolder = null) {

        if (!file_exists($templateFolder) || !is_dir($templateFolder)) {
            throw new TemplateException('The templateFolder ('.$templateFolder.') is not a valid directory.');
        }

        if (!empty($cacheFolder)) {
            if (!file_exists($cacheFolder) || !is_dir($cacheFolder)) {
                throw new TemplateException('The cacheFolder ('.$cacheFolder.') is not a valid directory.');
            }
        }

        if (empty($cacheFolder)) {
            $cacheFolder = false;
        }

        $this->templateFolder = $templateFolder;
        $this->cacheFolder = $cacheFolder;

    }

    public function create() {
        \Twig_Autoloader::register();

        $loader = new \Twig_Loader_Filesystem($this->templateFolder);
        $twig = new \Twig_Environment($loader, [
            'cache' => $this->cacheFolder,
            'debug' => true
        ]);

        $twig->addExtension(new \Twig_Extension_Debug());

        return new TwigTemplate($twig);
    }

}
