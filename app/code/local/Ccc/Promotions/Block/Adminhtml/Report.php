<?php
class Ccc_Promotions_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_report';
        $this->_blockGroup = 'promotions';
        $this->_headerText = Mage::helper('promotions')->__('Promotion Report');
        parent::__construct();
    }

    protected function getTags()
    {
        $activeTags = Mage::getModel('promotions/promotions')->getCollection()
            ->addFieldToFilter('is_active', 1);

        $options = [];
        foreach ($activeTags as $tag) {
            $options[$tag->getId()] = $tag->getTagName();
        }
        return $options;
    }
}