<?php

class Ccc_Promotions_Block_Adminhtml_Promotions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'promotions';
        $this->_controller = 'adminhtml_promotions';

        $this->_updateButton('save', 'label', Mage::helper('promotions')->__('Save Promotion'));
        $this->_updateButton('delete', 'label', Mage::helper('promotions')->__('Delete Promotion'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        $promotion = Mage::registry('current_promotion');
        if ($promotion && $promotion->getId()) {
            return Mage::helper('promotions')->__("Edit Promotion '%s'", $this->escapeHtml($promotion->getTagName()));
        } else {
            return Mage::helper('promotions')->__('Add Promotion');
        }
    }
}