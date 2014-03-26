<?php

namespace ConcreteEmployees\Tests\Tests\Unit\Builders;
use ConcreteEmployees\Infrastructure\Builders\ConcreteEmployeeBuilder;
use ObjectLoaders\Tests\Helpers\ObjectLoaderAdapterHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderHelper;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteEmployeeBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $booleanAdapterMock;
    private $objectLoaderAdapterMock;
    private $uuidMock;
    private $nameMock;
    private $dateTimeMock;
    private $objectLoaderMock;
    private $employeeMock;
    private $invalidEmployeeMock;
    private $classNameElement;
    private $invalidClassNameElement;
    private $paramsData;
    private $paramsWithLastUpdatedData;
    private $builder;
    private $invalidBuilder;
    private $objectLoaderAdapterHelper;
    private $objectLoaderHelper;
    
    public function setUp() {
        
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->objectLoaderAdapterMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter');
        $this->nameMock = $this->getMock('Strings\Domain\Strings\String');
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->objectLoaderMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\ObjectLoader');
        $this->employeeMock = $this->getMock('Employees\Domain\Employees\Employee');
        $this->invalidEmployeeMock = $this->getMock('ConcreteEmployees\Tests\Tests\Helpers\InvalidEmployee');
        
        $this->classNameElement = 'ConcreteEmployees\Infrastructure\Objects\ConcreteEmployee';
        $this->invalidClassNameElement = 'ConcreteEmployees\Tests\Tests\Helpers\ConcreteInvalidEmployee';
        
        $this->paramsData = array($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock);
        $this->paramsWithLastUpdatedData = array($this->uuidMock, $this->nameMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->builder = new ConcreteEmployeeBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock, $this->classNameElement);
        $this->invalidBuilder = new ConcreteEmployeeBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock, $this->invalidClassNameElement);
        
        $this->objectLoaderAdapterHelper = new ObjectLoaderAdapterHelper($this, $this->objectLoaderAdapterMock);
        $this->objectLoaderHelper = new ObjectLoaderHelper($this, $this->objectLoaderMock);
    }
    
    public function tearDown() {
        
    }
    
    public function testBuild_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->employeeMock, $this->paramsData);
        
        $employee = $this->builder->create()
                                    ->withName($this->nameMock)
                                    ->withUuid($this->uuidMock)
                                    ->createdOn($this->dateTimeMock)
                                    ->now();
        
        $this->assertEquals($this->employeeMock, $employee);
    }
    
    public function testBuild_throwsCannotInstantiateObjectException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->invalidClassNameElement);
        $this->objectLoaderHelper->expects_instantiate_throwsCannotInstantiateObjectException($this->paramsData);
        
        $asserted = false;
        try {
        
            $this->invalidBuilder->create()
                                    ->withName($this->nameMock)
                                    ->withUuid($this->uuidMock)
                                    ->createdOn($this->dateTimeMock)
                                    ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
    }
    
    public function testBuild_throwsCannotConvertClassNameElementToObjectLoaderException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_throwsCannotConvertClassNameElementToObjectLoaderException($this->invalidClassNameElement);
        
        $asserted = false;
        try {
        
            $this->invalidBuilder->create()
                                    ->withName($this->nameMock)
                                    ->withUuid($this->uuidMock)
                                    ->createdOn($this->dateTimeMock)
                                    ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
    }
    
    public function testBuild_lastUpdatedOn_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->employeeMock, $this->paramsWithLastUpdatedData);
        
        $employee = $this->builder->create()
                                    ->withName($this->nameMock)
                                    ->withUuid($this->uuidMock)
                                    ->createdOn($this->dateTimeMock)
                                    ->lastUpdatedOn($this->dateTimeMock)
                                    ->now();
        
        $this->assertEquals($this->employeeMock, $employee);
    }
    
    public function testImplementsRightInterface_Success() {
        
        $this->assertTrue($this->builder instanceof \Employees\Domain\Employees\Builders\EmployeeBuilder);
        
    }
    
    public function testExtendsRightAbstractClass_Success() {
        
        $this->assertTrue($this->builder instanceof \ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder);
        
    }
    
    public function testIsFinal_Success() {
        
        $reflectionClass = new \ReflectionClass($this->builder);
        $this->assertTrue($reflectionClass->isFinal());
        
    }
    
}