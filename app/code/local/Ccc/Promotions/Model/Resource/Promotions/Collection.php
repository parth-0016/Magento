<?php

class Ccc_Promotions_Model_Resource_Promotions_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct(){
        $this->_init('promotions/promotions');
    }
}