<?php

class Ccc_Salesman_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Salesman'))
            ->_title($this->__('Salesman Report'));
        $this->loadLayout()
            ->_setActiveMenu('salesman/salesman');
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('salesman/adminhtml_report')->getGridHtml()
        );
    }
}