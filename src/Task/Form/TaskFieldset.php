<?php

namespace Task\Form;

use Task\Model\Task;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;

class TaskFieldset extends Fieldset
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->setHydrator(new ClassMethods(false));
        $this->setObject(new Task());

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Title',
            ],
        ]);
    }
}