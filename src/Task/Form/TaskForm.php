<?php

namespace Task\Form;

use Zend\Form\Form;

class TaskForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->add([
            'name' => 'task-fieldset',
            'type' => 'Task\Form\TaskFieldset',
            'options' => [
                'use_as_base_fieldset' => true,
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ],
        ]);
    }
}