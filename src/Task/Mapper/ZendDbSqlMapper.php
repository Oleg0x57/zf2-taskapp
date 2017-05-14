<?php

namespace Task\Mapper;

use Task\Model\TaskInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements TaskMapperInterface
{
    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var TaskInterface
     */
    protected $taskPrototype;

    /**
     * @param AdapterInterface $dbAdapter
     * @param HydratorInterface $hydrator
     * @param TaskInterface $taskPrototype
     */
    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, TaskInterface $taskPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->taskPrototype = $taskPrototype;
    }

    /**
     * @param int $id
     * @return TaskInterface
     */
    public function find($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('task');
        $select->where(['id = ?' => $id]);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->taskPrototype);
        }

        throw new \InvalidArgumentException("Task with given ID:{$id} not found.");
    }

    /**
     * @return array|TaskInterface[]
     */
    public function findAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('task');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->taskPrototype);
            return $resultSet->initialize($result);
        }
        return [];
    }

    /**
     * @param TaskInterface $taskObject
     * @return TaskInterface
     * @throws \Exception
     */
    public function save(TaskInterface $taskObject)
    {
        $taskData = $this->hydrator->extract($taskObject);
        unset($taskData['id']);
        if ($taskObject->getId()) {
            $action = new Update('task');
            $action->set($taskData);
            $action->where(['id = ?' => $taskObject->getId()]);
        } else {
            $action = new Insert('task');
            $action->values($taskData);
        }
        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();
        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $taskObject->setId($newId);
            }
            return $taskObject;
        }
        throw new \Exception('Database error');
    }


    /**
     * @inheritdoc
     */
    public function delete(TaskInterface $taskObject)
    {
        $action = new Delete('task');
        $action->where(['id = ?' => $taskObject->getId()]);
        $sql = new Sql($this->dbAdapter);
        $stmt = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool)$result->getAffectedRows();
    }
}