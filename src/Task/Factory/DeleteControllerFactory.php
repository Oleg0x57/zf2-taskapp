<?php

namespace Task\Factory;

use Interop\Container\ContainerInterface;
use Task\Controller\DeleteController;
use Zend\ServiceManager\Factory\FactoryInterface;

class DeleteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $taskService = $container->get('Task\Service\TaskServiceInterface');
        return new DeleteController($taskService);
    }
}