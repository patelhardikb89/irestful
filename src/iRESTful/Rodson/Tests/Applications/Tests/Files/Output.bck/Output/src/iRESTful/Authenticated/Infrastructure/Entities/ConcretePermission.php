<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Permission;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> permission
*/
final class ConcretePermission extends AbstractEntity implements Permission {
    private $title;
    private $canRead;
    private $canWrite;
    private $canDelete;
    private $description;
    
    /**
    *   @title -> getTitle() -> title 
    *   @canRead -> getCanRead() -> can_read 
    *   @canWrite -> getCanWrite() -> can_write 
    *   @canDelete -> getCanDelete() -> can_delete 
    *   @description -> getDescription() -> description 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $canRead, $canWrite, $canDelete, $description = null) {
        if (is_null($title) || !is_string($title)) {
            throw new \Exception("The title must be a non-null string.");
        }
        
        if (!is_null($description) && !is_string($description)) {
            throw new \Exception("The description must be a string if non-null.");
        }
        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->canRead = (bool) $canRead;
        $this->canWrite = (bool) $canWrite;
        $this->canDelete = (bool) $canDelete;
        $this->description = $description;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getCanRead() {
        return $this->canRead;
    }
    
    public function getCanWrite() {
        return $this->canWrite;
    }
    
    public function getCanDelete() {
        return $this->canDelete;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
}
