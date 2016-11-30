<?php
namespace iRESTful\Rodson\Outputs\Infrastructure\Objects;
use  iRESTful\Rodson\Outputs\Domain\Templates\Template;

final class TwigTemplate implements Template {
    private $twig;
    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function render($file, array $data = null) {

        if (empty($data)) {
            $data = [];
        }

        return $this->twig->render($file, $data);
    }

}
