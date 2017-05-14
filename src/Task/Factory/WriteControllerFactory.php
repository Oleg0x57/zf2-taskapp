<?php

namespace Task\Factory;

use Interop\Container\ContainerInterface;
use Task\Controller\WriteController;
use Zend\ServiceManager\Factory\FactoryInterface;

class WriteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $taskService = $container->get('Task\Service\TaskServiceInterface');
        $taskInsertForm = $container->get('FormElementManager')->get('Task\Form\TaskForm');
        return new WriteController($taskService, $taskInsertForm);
    }
}