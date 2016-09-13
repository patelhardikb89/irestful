<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Authors\Author;
use iRESTful\Rodson\Domain\Inputs\Authors\Emails\Email;
use iRESTful\Rodson\Domain\Inputs\URLs\Url;

final class ConcreteAuthor implements Author {
    private $name;
    private $email;
    private $url;
    public function __construct($name, Email $email, Url $url = null) {
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function hasUrl() {
        return !empty($this->url);
    }

    public function getUrl() {
        return $this->url;
    }

    public function getData() {
        $output = [
            'name' => $this->name,
            'email' => $this->email->get()
        ];

        if ($this->hasUrl()) {
            $output['url'] = $this->url->get();
        }

        return $output;
    }

}
