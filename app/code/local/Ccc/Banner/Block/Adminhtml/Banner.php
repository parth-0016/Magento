<?php

class Ccc_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'banner';
        $this->_headerText = 'Static Blocks';
        parent::__construct();
        if (!Mage::getSingleton('admin/session')->isAllowed('banner/actions/showbutton')) {
            $this->_removeButton('add');
        }
    }

    // protected function _prepareLayout()
    // {
    //     if (!Mage::getSingleton('admin/session')->isAllowed('banner/actions/showbutton')) {
    //         $this->_removeButton('add');
    //     }
    //     return parent::_prepareLayout();
    // }
}