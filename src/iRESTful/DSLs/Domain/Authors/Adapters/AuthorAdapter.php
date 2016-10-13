<?php
namespace iRESTful\DSLs\Domain\Authors\Adapters;

interface AuthorAdapter {
    public function fromDataToAuthors(array $data);
    public function fromDataToAuthor(array $data);
}
