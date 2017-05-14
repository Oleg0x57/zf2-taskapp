<?php

namespace Task\Mapper;

use Task\Model\TaskInterface;

interface TaskMapperInterface
{
    /**
     * @param integer $id
     * @return TaskInterface
     */
    public function find($id);

    /**
     * @return array|TaskInterface[]
     */
    public function findAll();

    /**
     * @param TaskInterface $taskObject
     * @return mixed
     */
    public function save(TaskInterface $taskObject);

    /**
     * @param TaskInterface $taskObject
     * @return bool
     */
    public function delete(TaskInterface $taskObject);
}