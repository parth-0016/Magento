<?php

class Ccc_Promotions_Block_Adminhtml_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected $_activeTagOptions;
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('active_tag')
            ->addAttributeToSelect('special_price');

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField(
                'qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left'
            );
        }
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'custom_name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        } else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumnAfter(
            'active_tag',
            array(
                'header' => Mage::helper('catalog')->__('Active Tag'),
                'index' => 'active_tag',
                'type' => 'options',
                'options' => $this->_getActiveTagOptions(),
            ),
            'sku'
        );

        $this->addColumnAfter(
            'special_price',
            array(
                'header' => Mage::helper('catalog')->__('Special Price'),
                'index' => 'special_price',
                'type' => 'price',
                'currency_code' => Mage::app()->getStore()->getBaseCurrency()->getCode(),
            ),
            'active_tag'
        );

        return parent::_prepareColumns();
    }

    protected function _getActiveTagOptions()
    {
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'active_tag');
        if ($attribute->usesSource()) {
            $this->_activeTagOptions = $attribute->getSource()->getAllOptions(false);
        }
        $options = array();
        if ($this->_activeTagOptions) {
            foreach ($this->_activeTagOptions as $option) {
                $options[$option['value']] = $option['label'];
            }
        }
        return $options;
    }
}