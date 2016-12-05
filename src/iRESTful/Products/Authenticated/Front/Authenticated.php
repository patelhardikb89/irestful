<?php

function authenticated_front_authenticate($serviceFactory, $httpRequest) {

    $httpRequest->getInput();

    $repository = $serviceFactory->getRepository()->getEntity();
    $entity = $repository->retrieve([
        'container' => 'role',
        'uuid' => $httpRequest->get('uuid')
    ]);

    return $serviceFactory->getAdapter()->getEntity()->fromEntityToData($entity);

};

function authenticated_front_authenticate_test($serviceFactory, $phpunit) {



};
