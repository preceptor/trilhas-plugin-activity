<?php

class Activity_Model_ActivityTest extends PHPUnit_Framework_TestCase
{
    public function testInitialization()
    {
        $this->assertInstanceOf('Activity_Model_Activity', new Activity_Model_Activity());
    }
    
    public function testFindByClassroom()
    {
        $model = new Activity_Model_Activity();
        $model->findByClassroom(1);
    }
}