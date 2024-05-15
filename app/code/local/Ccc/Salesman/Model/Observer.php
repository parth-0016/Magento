<?php
class Ccc_Salesman_Model_Observer
{
    public function saveNewData()
    {
        $date = Mage::getModel('core/date')->date('y-m-d');
        echo $date;
        // $startDate = $date . "00:00:00";
        $startDate = "24-04-17" . " 00:00:00";
        $endDate = $date . " 23:59:59";
        
        $collection = Mage::getModel('salesman/commission')->getCollection();
        $collection->addFieldToFilter('created_at',['from'=>$startDate, 'to'=>$endDate, 'datetime'=>true]);

        $collection->getSelect()->join(
            array('salesman' => Mage::getSingleton('core/resource')->getTableName('admin/user')),
            'main_table.user_id = salesman.user_id',
            array('username' => 'salesman.username')
        );
        $collection->getSelect()->columns(array(
            'total_commission' => new Zend_Db_Expr('SUM(commission)'),
        ));
        $collection->getSelect()->group('order_id');
        $data = $collection->getData();
        $column = array_column($data, 'total_commission');
        array_multisort($column, SORT_DESC, $data);
        $overallRank = 1;
        foreach ($data as $key => $value) {
            $data[$key]['rank'] = $overallRank++;
        }
        $rank = 1;
        // Mage::log(Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($collection->getSelect()->__toString()),null,'abc.log');
        // Mage::log($collection->getSelect()->__toString(),null,'abc.log');
        // print_r($collection->getData());
        Mage::log($data, null , 'xyz.log');
    }
}