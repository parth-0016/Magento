<?php

class Ccc_Promotions_Adminhtml_PromotionsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/promotions');
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('promotions/promotions');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('promotions')->__('This promotion no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Promotion'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('promotions', $model);

        $this->loadLayout()
            ->_setActiveMenu('catalog/promotions');
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('promotions/promotions');

            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }
            $model->addData($data);

            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('promotions')->__('The Promotion has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }

            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('promotions/promotions');
                echo $id;
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('promotions')->__('The Promotion has been deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massStatusAction()
    {
        $promotionIds = $this->getRequest()->getParam('promotions');
        $status = $this->getRequest()->getParam('is_active');

        if (!is_array($promotionIds) || empty($promotionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('promotions')->__('Please select promotions.')
            );
        } else {
            try {
                foreach ($promotionIds as $promotionId) {
                    $promotion = Mage::getSingleton('promotions/promotions')->load($promotionId);
                    $promotion->setIsActive($status)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('promotions')->__('Total of %d promotions(s) were successfully updated.', count($promotionIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        $aclResource = '';
        $action = strtolower($this->getRequest()->getActionName());
            switch ($action) {
                case 'promotions':
                    $aclResource = 'admin/catalog/promotions/promotions';
                    break;

                case 'report':
                    $aclResource = 'admin/catalog/promotions/report';
                    break;

                default:
                    $aclResource = 'admin/catalog/promotions/promotions';
                    break;
            }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }


    public function reportAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/promotions/report');
        $this->renderLayout();
    }

    public function loadReportAction()
    {
        $tagName = $this->getRequest()->getParam('tag');
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'active_tag');
        $tagId = $attribute->getSource()->getOptionId($tagName);
        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect(array('name', 'price', 'special_price'))
            ->addAttributeToFilter('active_tag', $tagId);

        $productData = [];
        foreach ($products as $product) {
            $productData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'price' => $product->getPrice(),
                'special_price' => $product->getSpecialPrice(),
            ];
        }
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($productData));
    }

    public function assignTagAction()
    {
        $sku = $this->getRequest()->getParam('sku');
        $tagName = $this->getRequest()->getParam('tag');
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'active_tag');
        $tagId = $attribute->getSource()->getOptionId($tagName);

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
        if ($product) {
            $product->setData('active_tag', $tagId);
            $product->save();

            $response = array();
            $response['success'] = true;
            $response['message'] = 'Tag assigned successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid SKU, Failed to assign Tag.';
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}