<?php

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$entityType = $installer->getEntityTypeId('catalog_product');
$installer->startSetup();

$attributeCode = 'active_tag';
$attributeLabel = 'Active Tag';
$promotions = Mage::getModel('promotions/promotions')->getCollection()
    ->addFieldToFilter('is_active', 1);
$options = array();
foreach ($promotions as $promotion) {
    $options[$promotion->getTagName()] = array(0 => $promotion->getTagName());
}

$data = array(
    'attribute_code' => $attributeCode,
    'type' => 'varchar',
    'input' => 'select',
    'label' => $attributeLabel,
    'source' => 'eav/entity_attribute_source_table',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'configurable' => false,
    'apply_to' => 'simple,configurable',
    'visible_on_front' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
    'option' => array('value' => $options)
);

$installer->addAttribute($entityType, $attributeCode, $data);

$attributeCode = 'special_price';
$attributeLabel = 'Special Price';

$data = array(
    'attribute_code' => $attributeCode,
    'type' => 'decimal',
    'input' => 'price',
    'label' => $attributeLabel,
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'required' => false,
    'configurable' => false,
    'apply_to' => 'simple,configurable',
    'visible_on_front' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
);

$installer->addAttribute($entityType, $attributeCode, $data);

$installer->endSetup();