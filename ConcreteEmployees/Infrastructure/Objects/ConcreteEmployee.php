<?php
namespace ConcreteEmployees\Infrastructure\Objects;
use Uuids\Domain\Uuids\Uuid;
use Strings\Domain\Strings\String;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Employees\Domain\Employees\Employee;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;

final class ConcreteEmployee extends AbstractEntity implements Employee {
    
    private $name;
    
    public function __construct(Uuid $uuid, String $name, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        $this->name = $name;
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
    }
    
    public function getName() {
        return $this->name;
    }
}
