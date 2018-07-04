<?php

namespace Tests\Unit;

use Doctrine\Bundle\DoctrineBundle\Registry;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function createRepositoryMock($repositoryClass, array $methods)
    {
        $repository = $this->getMockBuilder($repositoryClass)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();

        return $repository;
    }

    protected function createDoctrineMock()
    {
        return $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();
    }
}