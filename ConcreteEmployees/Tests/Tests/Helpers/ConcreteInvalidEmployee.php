<?php
namespace ConcreteEmployees\Tests\Tests\Helpers;
use Uuids\Domain\Uuids\Uuid;
use Strings\Domain\Strings\String;
use DateTime\Domain\DateTime\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ConcreteEmployees\Tests\Tests\Helpers\InvalidEmployee;

final class ConcreteInvalidEmployee implements InvalidEmployee {
    
    public function __construct(Uuid $uuid, String $name, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        
    }
}