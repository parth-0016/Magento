<?php

class Ccc_Promotions_Model_Promotions extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('promotions/promotions');
    }

    protected function _afterSave()
    {
        parent::_afterSave();

        $tagName = $this->getTagName();

        $attributeCode = 'active_tag';
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

        $attributeOptions = $attribute->getSource()->getAllOptions(false);

        foreach ($attributeOptions as $option) {
            if ($option['label'] == $tagName) {
                return;
            }
        }

        $option = array(
            'attribute_id' => $attribute->getId(),
            'value' => array(
                'option' => array(0 => $tagName)
            )
        );

        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($option);
    }
}