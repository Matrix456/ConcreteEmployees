<?php

namespace ConcreteEmployees\Tests\Tests\Unit\Objects;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use Primitives\Tests\Helpers\PrimitiveAdapterHelper;
use ConcreteEmployees\Infrastructure\Objects\ConcreteEmployee;

final class ConcreteEmployeeTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $nameMock;
    private $dateTimeMock;
    private $integerMock;
    private $booleanMock;
    private $booleanAdapterMock;
    private $createdOnTimestamp;
    private $lastUpdatedOnTimestamp;
    private $dateTimeHelper;
    private $integerHelper;
    private $booleanAdapterHelper;
    
    public function setUp() {
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->nameMock = $this->getMock('Strings\Domain\Strings\String');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->booleanMock = $this->getMock('Booleans\Domain\Booleans\Boolean');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        $this->booleanAdapterHelper = new PrimitiveAdapterHelper($this, $this->booleanAdapterMock);
        
        $this->createdOnTimestamp = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestamp = time();
    }
    
    public function tearDown() {
        
    }
    
    public function testCreateConcreteEmployee_withoutLastUpdatedOn_Success() {
        
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, false);
        
        $employee = new ConcreteEmployee($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $employee->getUuid());
        $this->assertEquals($this->nameMock, $employee->getName());
        $this->assertEquals($this->dateTimeMock, $employee->createdOn());
        $this->assertNull($employee->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $employee->hasBeenUpdated());
    }
    
    public function testCreateConcreteEmployee_withLastUpdatedOn_withDifferentTimestamps_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->createdOnTimestamp, $this->lastUpdatedOnTimestamp));
        $this->booleanAdapterHelper->expectsConvertElementToPrimitive_Success($this->booleanMock, true);
        
        $employee = new ConcreteEmployee($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $employee->getUuid());
        $this->assertEquals($this->nameMock, $employee->getName());
        $this->assertEquals($this->dateTimeMock, $employee->createdOn());
        $this->assertEquals($this->dateTimeMock, $employee->lastUpdatedOn());
        $this->assertEquals($this->booleanMock, $employee->hasBeenUpdated()); 
    }
    
    public function testImplementsRightInterface_Success() {
        
        $employee = new ConcreteEmployee($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        $this->assertTrue($employee instanceof \Employees\Domain\Employees\Employee);
        
    }
    
    public function testExtendsRightAbstractClass_Success() {
        
        $employee = new ConcreteEmployee($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        $this->assertTrue($employee instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testIsFinal_Success() {
        
        $employee = new ConcreteEmployee($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        $reflectionClass = new \ReflectionClass($employee);
        $this->assertTrue($reflectionClass->isFinal());
        
    }
}

