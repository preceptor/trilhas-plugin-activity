<?php
class Admin_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            'testing',
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp();
        
        $auth = Zend_Auth::getInstance();
        $user = new stdClass();
        $user->id = 1;
        $user->role = 'identified';
        $user->email = 'email@test.com';
        $auth->getStorage()->write($user);

        $session  = new Zend_Session_Namespace('data');
        $session->classroom_id = 1;
    }
    
    public function testIndexAction()
    {
        $this->dispatch('/activity');
        
        $this->assertModule('activity');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }
}