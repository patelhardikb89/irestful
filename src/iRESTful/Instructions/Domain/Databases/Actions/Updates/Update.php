<?php
namespace iRESTful\Instructions\Domain\Databases\Actions\Updates;

interface Update {
    public function getSource();
    public function getUpdated();
}
