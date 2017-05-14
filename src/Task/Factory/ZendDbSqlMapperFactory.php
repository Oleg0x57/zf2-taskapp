<?php

namespace Task\Factory;

use Task\Mapper\ZendDbSqlMapper;
use Interop\Container\ContainerInterface;
use Task\Model\Task;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;

class ZendDbSqlMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ZendDbSqlMapper($container->get('Zend\Db\Adapter\AdapterInterface'), new ClassMethods(), new Task());
    }
}