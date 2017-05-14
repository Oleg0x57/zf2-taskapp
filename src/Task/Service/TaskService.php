<?php

namespace Task\Service;

use Task\Model\Task;
use Task\Mapper\TaskMapperInterface;
use Task\Model\TaskInterface;

class TaskService implements TaskServiceInterface
{
    /**
     * @var TaskMapperInterface
     */
    protected $taskMapper;

    public function __construct(TaskMapperInterface $taskMapper)
    {
        $this->taskMapper = $taskMapper;
    }

    /**
     * @inheritdoc
     */
    public function findAllTasks()
    {
        return $this->taskMapper->findAll();
    }

    /**
     * @inheritdoc
     */
    public function findTask($id)
    {
        return $this->taskMapper->find($id);
    }

    /**
     * @inheritdoc
     */
    public function saveTask(TaskInterface $task)
    {
        return $this->taskMapper->save($task);
    }

    /**
     * @inheritdoc
     */
    public function deleteTask(TaskInterface $task)
    {
        return $this->taskMapper->delete($task);
    }
}