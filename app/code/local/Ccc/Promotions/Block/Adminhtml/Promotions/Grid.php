<?php
class Ccc_Promotions_Block_Adminhtml_Promotions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('promotionsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('promotions/promotions')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            array(
                'header' => Mage::helper('promotions')->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'id',
            )
        );

        $this->addColumn(
            'tag_name',
            array(
                'header' => Mage::helper('promotions')->__('Name'),
                'align' => 'left',
                'index' => 'tag_name',
            )
        );

        $this->addColumn(
            'percentage',
            array(
                'header' => Mage::helper('promotions')->__('Percentage'),
                'align' => 'left',
                'index' => 'percentage',
            )
        );

        $this->addColumn(
            'priority',
            array(
                'header' => Mage::helper('promotions')->__('Priority'),
                'align' => 'left',
                'index' => 'priority',
            )
        );

        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('promotions')->__('Is Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    1 => Mage::helper('adminhtml')->__('Yes'),
                    0 => Mage::helper('adminhtml')->__('No')
                ),
            )
        );

        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('promotions')->__('Created At'),
                'align' => 'left',
                'index' => 'created_at',
            )
        );

        $this->addColumn(
            'updated_date',
            array(
                'header' => Mage::helper('promotions')->__('Updated Date'),
                'align' => 'left',
                'index' => 'updated_date',
            )
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('promotions');

        $this->getMassactionBlock()->addItem('is_active', array(
            'label' => Mage::helper('promotions')->__('Update Is Active'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'is_active',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('promotions')->__('Is Active'),
                    'values' => array(
                        '1' => Mage::helper('promotions')->__('Yes'),
                        '0' => Mage::helper('promotions')->__('No')
                    )
                )
            )
        )
        );

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}