<?php

class Dvl_City_Adminhtml_SamosaController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        return $this;    
    }
    
    public function indexAction(){
        $this->_title($this->__('Reports'));
        $this->_initAction();
        $this->renderLayout();
    }
}