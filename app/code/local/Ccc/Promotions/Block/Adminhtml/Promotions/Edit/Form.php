<?php
class Ccc_Promotions_Block_Adminhtml_Promotions_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('promotions')->__('Promotion Information'),
            'class' => 'fieldset-wide'
        )
        );

        $fieldset->addField('tag_name', 'text', array(
            'label' => Mage::helper('promotions')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'tag_name',
        )
        );

        $fieldset->addField('percentage', 'text', array(
            'label' => Mage::helper('promotions')->__('Percentage'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'percentage',
        )
        );

        $fieldset->addField('priority', 'text', array(
            'label' => Mage::helper('promotions')->__('Priority'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'priority',
        )
        );

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('promotions')->__('Is Active'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'is_active',
            'values' => array(
                array('value' => 1, 'label' => Mage::helper('promotions')->__('Yes')),
                array('value' => 0, 'label' => Mage::helper('promotions')->__('No')),
            ),
        )
        );

        $form->setValues($this->_getPromotion()->getData());
        return parent::_prepareForm();
    }

    protected function _getPromotion()
    {
        return Mage::registry('promotions');
    }
}