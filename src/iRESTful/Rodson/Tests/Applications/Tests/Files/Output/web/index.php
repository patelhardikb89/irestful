<?php
use iRESTful\Authenticated\Infrastructure\Applications\AuthenticatedApplication;

include_once(__DIR__ . '/../vendor/autoload.php');

new AuthenticatedApplication($_SERVER, $_GET, $_POST);
