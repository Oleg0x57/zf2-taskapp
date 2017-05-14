<?php

namespace Task\Factory;

use Task\Service\TaskService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TaskServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TaskService($container->get('Task\Mapper\TaskMapperInterface'));
    }
}