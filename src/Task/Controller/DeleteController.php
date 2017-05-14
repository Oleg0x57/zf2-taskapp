<?php

namespace Task\Controller;

use Task\Service\TaskServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeleteController extends AbstractActionController
{
    /**
     * @var TaskServiceInterface
     */
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function deleteAction()
    {
        try {
            $task = $this->taskService->findTask($this->params('id'));
        } catch (\InvalidArgumentException $e) {
            return $this->redirect()->toRoute('task');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('delete_confirmation', 'no');
            if ($del === 'yes') {
                $this->taskService->deleteTask($task);
            }
            return $this->redirect()->toRoute('task');
        }
        return new ViewModel(['task' => $task]);
    }
}