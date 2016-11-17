<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Factories\ServerFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Adapters\ServerAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\NativePDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Factories\NativePDOFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions\NativePDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Exceptions\ServerException;

final class ConcreteServerFactory implements ServerFactory {
    private $serverAdapter;
    private $nativePDOFactory;
    public function __construct(ServerAdapter $serverAdapter, NativePDOFactory $nativePDOFactory) {
        $this->serverAdapter = $serverAdapter;
        $this->nativePDOFactory = $nativePDOFactory;
    }

    public function create() {

        try {

            $nativePDO = $this->nativePDOFactory->create();
            return $this->serverAdapter->fromNativePDOToServer($nativePDO);

        } catch (NativePDOException $exception) {
            throw new ServerException('There was an exception while creating a NativePDO object.', $exception);
        }
    }

}
