<?php

class Dvl_City_Block_Samosa extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        echo 121212;
        $this->_controller = 'samosa';
        $this->_blockGroup = 'city';
        // $this->setTemplate('city/samosa.phtml');
    }
}