<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Authors\Adapters\AuthorAdapter;
use iRESTful\Rodson\DSLs\Domain\Authors\Exceptions\AuthorException;
use iRESTful\Rodson\DSLs\Domain\Authors\Emails\Adapters\EmailAdapter;
use iRESTful\Rodson\DSLs\Domain\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteAuthor;

final class ConcreteAuthorAdapter implements AuthorAdapter {
    private $urlAdapter;
    private $emailAdapter;
    public function __construct(UrlAdapter $urlAdapter, EmailAdapter $emailAdapter) {
        $this->urlAdapter = $urlAdapter;
        $this->emailAdapter = $emailAdapter;
    }

    public function fromDataToAuthors(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $author = $this->fromDataToAuthor($oneData);

            $name = $author->getName();
            $output[$name] = $author;
        }

        return $output;
    }

    public function fromDataToAuthor(array $data) {

        if (!isset($data['name'])) {
            throw new AuthorException('The name keyname is mandatory in order to convert data to an Author object.');
        }

        if (!isset($data['email'])) {
            throw new AuthorException('The email keyname is mandatory in order to convert data to an Author object.');
        }

        if (!isset($data['url'])) {
            throw new AuthorException('The url keyname is mandatory in order to convert data to an Author object.');
        }

        $email = $this->emailAdapter->fromStringToEmail($data['email']);
        $url = $this->urlAdapter->fromStringToUrl($data['url']);
        return new ConcreteAuthor($data['name'], $email, $url);
    }

}
