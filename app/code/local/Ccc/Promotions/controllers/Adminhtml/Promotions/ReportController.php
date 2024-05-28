<?php

class Ccc_Promotions_Adminhtml_Promotions_ReportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/promotions_report');
        $this->renderLayout();
    }

    public function loadReportAction()
    {
        $tagId = $this->getRequest()->getParam('tag');

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*')
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
        print_r($productData);
        // $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json');
        // $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($productData));
    }
}