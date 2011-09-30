<?php
class Activity_IndexController extends Tri_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->view->title = "Activity";
    }

    public function indexAction()
    {
        $session = new Zend_Session_Namespace('data');
        $page    = Zend_Filter::filterStatic($this->_getParam('page'), 'int');
        $query   = Zend_Filter::filterStatic($this->_getParam("q"), 'stripTags');
        $model   = new Activity_Model_Activity();
        
        $this->view->data = $model->findByClassroom($session->classroom_id, $query, $page);
        $this->view->q = $query;
    }

    public function formAction()
    {
        $id   = Zend_Filter::filterStatic($this->_getParam('id'), 'int');
        $form = new Activity_Form_Activity();

        if ($id) {
            $table = new Tri_Db_Table('activity');
            $row   = $table->find($id)->current();

            if ($row) {
                $form->populate($row->toArray());
            }
        }

        $this->view->form = $form;
    }

    public function saveAction()
    {
        $form  = new Activity_Form_Activity();
        $table = new Tri_Db_Table('activity');
        $session = new Zend_Session_Namespace('data');
        $data  = $this->_getAllParams();

        if ($form->isValid($data)) {
            $data = $form->getValues();
            $data['user_id']      = Zend_Auth::getInstance()->getIdentity()->id;
            $data['classroom_id'] = $session->classroom_id;

            if (!$data['end']) {
                unset($data['end']);
            }

            if (isset($data['id']) && $data['id']) {
                $row = $table->find($data['id'])->current();
                $row->setFromArray($data);
                $id = $row->save();
            } else {
                unset($data['id']);
                $row = $table->createRow($data);
                $id = $row->save();
                Application_Model_Timeline::save('created a new activity', $data['title']);
            }

            $this->_helper->_flashMessenger->addMessage('Success');
            $this->_redirect('activity/index/');
        }

        $this->_helper->_flashMessenger->addMessage('Error');
        $this->view->form = $form;
        $this->render('form');
    }

    public function viewAction()
    {
        $id     = Zend_Filter::filterStatic($this->_getParam('id'), 'int');
        $userId = Zend_Filter::filterStatic($this->_getParam('userId'), 'int');
        $this->_redirect('/activity/text/index/layout/box/id/'.$id.'/userId/'.$userId);
    }
}