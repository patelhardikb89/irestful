<?php
use iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Applications\ConcreteEntityApplication;

// Include Composer autoloader
include_once(__DIR__ . '/../../../../../../../../../vendor/autoload.php');

new ConcreteEntityApplication(
    $_SERVER,
    $_GET,
    $_POST,
    '\iRESTful\LeoPaul\Applications\APIs\Entities\Infrastructure\Configurations\ConcreteEntityApplicationConfiguration',
    '\iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\ConcreteEntityObjectsConfiguration'
);
