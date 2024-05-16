<?php

class Ccc_Salesman_Adminhtml_BonusController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Salesman'))
            ->_title($this->__('Salesmen Bonus'));
        $this->loadLayout()
            ->_setActiveMenu('salesman/salesman');
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('salesman/adminhtml_bonus')->getGridHtml()
        );
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('entity_id');
            $model = Mage::getModel('salesman/bonus')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('This configuration no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            echo "<pre>";
            unset($data['form_key']);
            if (empty($model->getData())) {
                unset($data['entity_id']);
            }
            print_r($model->setData($data));
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('The configuration has been saved.'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
            }
        }
        $this->_redirect('*/*/league', array('id' => $model->getId()));
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('salesman/bonus');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bonus')->__('This configuration no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Block'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('bonus_configuration', $model);

        $this->loadLayout();
        // $this->loadLayout()->_setActiveMenu('salesman/bonus_configuration');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('configuration');
    }

    public function configurationAction()
    {
        $this->loadLayout();
        $this->loadLayout()->_setActiveMenu('salesman/bonus_configuration');

        $this->_addContent(
            $this->getLayout()->createBlock('salesman/adminhtml_bonus_tab_configuration')
        );
        Mage::register('bonus_configuration', $this->getLayout()->createBlock('salesman/adminhtml_bonus_tab_configuration'));
        $this->renderLayout();
    }

    public function leagueAction()
    {
        // Mage::dispatchEvent('bonus_config_data', array('request' => $this->getRequest()->getParams()));
        $this->loadLayout();

        $this->_addContent(
            $this->getLayout()->createBlock('salesman/adminhtml_bonus_tab_league')
        );
        Mage::register('bonus_league', $this->getLayout()->createBlock('salesman/adminhtml_bonus_Tab_league'));
        $this->renderLayout();
    }

    public function dataAction(){
        $bonus = Mage::getStoreConfig('salesman/bonus/amount');
        $cardData = json_decode($this->getRequest()->getParam('data'),true);
        // echo "<pre>";
        // print_r($cardData);
        // echo "</pre>";
        $response['success'] = true;
        echo json_encode($response);
    }
}