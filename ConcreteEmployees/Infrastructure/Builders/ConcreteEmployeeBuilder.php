<?php
namespace ConcreteEmployees\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use Employees\Domain\Employees\Builders\EmployeeBuilder;
use Strings\Domain\Strings\String;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;

final class ConcreteEmployeeBuilder extends AbstractEntityBuilder implements EmployeeBuilder {
    
   private $name;
   
   public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter, $classNameElement) {
       parent::__construct($booleanAdapter, $objectLoaderAdapter, $classNameElement);
   }
   
   public function withName(String $name) {
       $this->name = $name;
       return $this;
   }
   
   protected function getParamsData() {
        
        $paramsData = array($this->uuid, $this->name, $this->createdOn, $this->booleanAdapter);
        
        if (!empty($this->lastUpdatedOn)) {
            $paramsData[] = $this->lastUpdatedOn;
        }
        
        return $paramsData;
    }
}