<?php

class Ccc_Salesman_Block_Adminhtml_Bonus_Tab_Abc extends Mage_Adminhtml_Block_Widget_Form
    // implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    // protected function _prepareForm()
    // {
    //     /* @var $model Mage_Cms_Model_Page */
    //     $model = Mage::registry('cms_page');

    //     /*
    //      * Checking if user have permissions to save information
    //      */
    //     if ($this->_isAllowedAction('save')) {
    //         $isElementDisabled = false;
    //     } else {
    //         $isElementDisabled = true;
    //     }


    //     $form = new Varien_Data_Form();

    //     $form->setHtmlIdPrefix('page_');

    //     $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('cms')->__('Page Information')));

    //     if ($model->getPageId()) {
    //         $fieldset->addField('page_id', 'hidden', array(
    //             'name' => 'page_id',
    //         ));
    //     }

    //     $fieldset->addField('title', 'text', array(
    //         'name'      => 'title',
    //         'label'     => Mage::helper('cms')->__('Page Title'),
    //         'title'     => Mage::helper('cms')->__('Page Title'),
    //         'required'  => true,
    //         'disabled'  => $isElementDisabled
    //     ));

    //     $fieldset->addField('identifier', 'text', array(
    //         'name'      => 'identifier',
    //         'label'     => Mage::helper('cms')->__('URL Key'),
    //         'title'     => Mage::helper('cms')->__('URL Key'),
    //         'required'  => true,
    //         'class'     => 'validate-identifier',
    //         'note'      => Mage::helper('cms')->__('Relative to Website Base URL'),
    //         'disabled'  => $isElementDisabled
    //     ));

    //     /**
    //      * Check is single store mode
    //      */
    //     if (!Mage::app()->isSingleStoreMode()) {
    //         $field = $fieldset->addField('store_id', 'multiselect', array(
    //             'name'      => 'stores[]',
    //             'label'     => Mage::helper('cms')->__('Store View'),
    //             'title'     => Mage::helper('cms')->__('Store View'),
    //             'required'  => true,
    //             'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
    //             'disabled'  => $isElementDisabled,
    //         ));
    //         $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
    //         $field->setRenderer($renderer);
    //     }
    //     else {
    //         $fieldset->addField('store_id', 'hidden', array(
    //             'name'      => 'stores[]',
    //             'value'     => Mage::app()->getStore(true)->getId()
    //         ));
    //         $model->setStoreId(Mage::app()->getStore(true)->getId());
    //     }

    //     $fieldset->addField('is_active', 'select', array(
    //         'label'     => Mage::helper('cms')->__('Status'),
    //         'title'     => Mage::helper('cms')->__('Page Status'),
    //         'name'      => 'is_active',
    //         'required'  => true,
    //         'options'   => $model->getAvailableStatuses(),
    //         'disabled'  => $isElementDisabled,
    //     ));
    //     if (!$model->getId()) {
    //         $model->setData('is_active', $isElementDisabled ? '0' : '1');
    //     }

    //     Mage::dispatchEvent('adminhtml_cms_page_edit_tab_main_prepare_form', array('form' => $form));

    //     $form->setValues($model->getData());
    //     $this->setForm($form);

    //     return parent::_prepareForm();
    // }
    public function __construct()
    {
        // echo 1212121212;
    }
}