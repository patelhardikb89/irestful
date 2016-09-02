<?php
namespace iRESTful\Rodson\Infrastructure\Outputs\Objects;
use iRESTful\Rodson\Domain\Outputs\Templates\Template;

final class TwigTemplate implements Template {
    private $twig;
    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function render($file, array $data) {
        return $this->twig->render($file, $data);
    }

}
