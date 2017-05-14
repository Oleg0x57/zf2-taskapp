<?php

namespace Task\Controller;

use Task\Service\TaskServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    /**
     * @var \Task\Service\TaskServiceInterface
     */
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function indexAction()
    {
        return new ViewModel([
            'tasks' => $this->taskService->findAllTasks()
        ]);
    }

    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        try {
            $task = $this->taskService->findTask($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('task');
        }
        return new ViewModel([
            'task' => $task,
        ]);
    }
}