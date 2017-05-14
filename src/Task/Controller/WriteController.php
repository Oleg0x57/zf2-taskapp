<?php

namespace Task\Controller;

use Zend\Form\FormInterface;
use Task\Service\TaskServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class WriteController extends AbstractActionController
{
    /**
     * @var \Task\Service\TaskServiceInterface
     */
    protected $taskService;

    /**
     * @var \Zend\Form\FormInterface
     */
    protected $taskForm;

    /**
     * @param TaskServiceInterface $taskService
     * @param FormInterface $taskForm
     */
    public function __construct(TaskServiceInterface $taskService, FormInterface $taskForm)
    {
        $this->taskService = $taskService;
        $this->taskForm = $taskForm;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $this->taskForm->setData($request->getPost());
            if ($this->taskForm->isValid()) {
                try {
                    $this->taskService->saveTask($this->taskForm->getData());
                    return $this->redirect()->toRoute('task');
                } catch (\Exception $e) {
                    //
                }
            }
        }
        return new ViewModel([
            'form' => $this->taskForm,
        ]);
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $task = $this->taskService->findTask($this->params('id'));
        $this->taskForm->bind($task);
        if ($request->isPost()) {
            $this->taskForm->setData($request->getPost());
            if ($this->taskForm->isValid()) {
                try {
                    $this->taskService->saveTask($task);
                    return $this->redirect()->toRoute('task');
                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
        }
        return new ViewModel([
            'form' => $this->taskForm,
        ]);
    }
}