<?php

class Ccc_Salesman_Model_Resource_Metric_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct(){
        $this->_init('salesman/metric');
    }
}