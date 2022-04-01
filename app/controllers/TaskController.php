<?php

class TaskController extends ApplicationController
{

    public function __construct()
    {
        require_once ROOT_PATH . '/app/models/Task.php';
    }

    public function indexAction()
    {
        // call to model
        $model = new Task();
        // fetch the data, if any
        $data['taskList'] = $model->fetchAll();
        // call to view
        // set the data for the view
        $this->view->data = $data['taskList'];
        // set the layout (template) of the view
        $this->view->setLayout('indexLayout');
        // render the view using the proper view script
        // $this->view->render('/task/index.phtml');
    }

    public function addAction()
    {
        // call to view
        // show an empty form to input the task's details
        // set the layout (template) of the view
        $this->view->setLayout('addTaskLayout');
        // render the view using the proper view script
        // $this->view->render('/task/add.phtml');
        // once the user hits the "SAVE" button, send the data
        // if the request method is POST, then
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // get the data from the view (sent by the user)
            // and sanitize them before saving
            $data = array(
                'task_description' => trim($_POST['description']),
                'date_time_start' => $_POST['start'],
                'date_time_end' => $_POST['end'],
                'task_state' => $_POST['state'],
                'user_first_name' => trim($_POST['userFirstName']),
                'user_last_name' => trim($_POST['userLastName'])
            );
            // call to model
            // start the connection to the database
            $model = new Task();
            // save them to the database and 
            // if OK, redirects to the index page
            if($model->save($data))
            {
                header('Location: index');
            }
        
        }
        
    }

    public function ShowAction()
    {
         // get the 'id' of the task 
        //(int) ($this->_getParam('id'));
        // call to model
        // start the connection tot the database
        $model = new Task();
        // fetch the data
        $data['show'] = $model->fetchOne($this->_getParam('id'));
        // call to view
        // set the data for the view
        $this->view->data = $data['show'];
        // set the layout (template) of the view
        $this->view->setLayout('showTaskLayout');
        // render the view using the proper view script
        // $this->view->render('/task/show.phtml');
    }

    public function updateAction()
    {
        // get the 'id' of the task 
        //(int) ($this->_getParam('id'));
        // call to model
        // start the connection tot the database
        $model = new Task();
        // fetch the data
        $data['update'] = $model->fetchOne($this->_getParam('id'));
        // call to view
        // set the data for the view
        $this->view->data = $data['update'];
        // set the layout (template) of the view
        $this->view->setLayout('updateTaskLayout');
        // render the view using the proper view script
        // $this->view->render('/task/update.phtml');

        // once the user hits the "UPDATE" button, send the data
        // if the request method is POST, then
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // get the data from the view (sent by the user)
            // and sanitize them before updating
            $data = array(
                'id' => $_POST['id'],
                'task_description' => trim($_POST['description']),
                'date_time_start' => $_POST['start'],
                'date_time_end' => $_POST['end'],
                'task_state' => $_POST['state'],
                'user_first_name' => trim($_POST['userFirstName']),
                'user_last_name' => trim($_POST['userLastName'])
            );
        }
        // call to model
        // start the connection to the database
        $task = new Task();
        // update the task in the database
        // if OK, redirects to the index page
        if($task->save($data))
        {
            header('Location: index');
        }
        
        
    }

    public function deleteAction()
    {
        // get the 'id' of the task 
        // $this->_getParam('id'));
        // call to model
        // start the connection tot the database
        $model = new Task();
        // fetch the data
        $data['delete'] = $model->fetchOne((int) $this->_getParam('id'));
        // call to view
        // set the data for the view
        $this->view->data = $data['delete'];
        // set the layout (template) of the view
        $this->view->setLayout('deleteTaskLayout');
        // render the view using the proper view script
        // $this->view->render('/task/delete.phtml');
        
        // once the user hits the "UPDATE" button
        // if the request method is POST, then
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // get the data from the view (sent by the user)
            // and sanitize them before updating
            $data = array(
                'id' => $_POST['id'],
                'task_description' => trim($_POST['description']),
                'date_time_start' => $_POST['start'],
                'date_time_end' => $_POST['end'],
                'task_state' => $_POST['state'],
                'user_first_name' => trim($_POST['userFirstName']),
                'user_last_name' => trim($_POST['userLastName'])
            );
        }
        // call to model
        // start the connection to the database
        $task = new Task();
        // delete the task from the database
        // if OK, redirects to the index page
        if ($model->delete((int) $this->_getParam('id')))
        {
            header('Location: index');
        }
    }

}