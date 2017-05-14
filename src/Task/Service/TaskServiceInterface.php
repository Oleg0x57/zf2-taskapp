<?php

namespace Task\Service;

use Task\Model\TaskInterface;

interface TaskServiceInterface
{
    /**
     * @return array|TaskInterface[]
     */
    public function findAllTasks();

    /**
     * @param int $id
     * @return TaskInterface
     */
    public function findTask($id);

    /**
     * @param TaskInterface $task
     * @return TaskInterface
     */
    public function saveTask(TaskInterface $task);

    /**
     * @param TaskInterface $task
     * @return bool
     */
    public function deleteTask(TaskInterface $task);
}