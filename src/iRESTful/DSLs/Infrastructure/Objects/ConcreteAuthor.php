<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Authors\Author;
use iRESTful\DSLs\Domain\Authors\Emails\Email;
use iRESTful\DSLs\Domain\URLs\Url;

final class ConcreteAuthor implements Author {
    private $name;
    private $email;
    private $url;
    public function __construct(string $name, Email $email, Url $url = null) {
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function hasUrl(): bool {
        return !empty($this->url);
    }

    public function getUrl() {
        return $this->url;
    }

}
