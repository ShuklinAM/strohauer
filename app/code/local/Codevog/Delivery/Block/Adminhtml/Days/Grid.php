<?php
class Codevog_Delivery_Block_Adminhtml_Days_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
       


        $this->setId('daysGrid');
        $this->_controller = 'adminhtml_days';
        $this->setUseAjax(true);
        
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        
    }
 
    protected function _prepareCollection()
    {
       
        $collection = Mage::getModel('delivery/days')->getCollection();
      //  $collection->getSelect()->join(e, 'main_table.entity_id = discount_percents.item_id');
        $this->setCollection($collection);  
      
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    { 
       
        
       $this->addColumn('name', array(
            'header'        => Mage::helper('codevog_delivery')->__('Name'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'name',
            'index'         => 'name'
        ));
        $this->addColumn('disable', array(
          'header'    => Mage::helper('codevog_delivery')->__('Is weekend'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'disable',
          'type'      => 'options',
          'options'   => array(
              0 => 'No',
              1 => 'Yes',
          ),
      ));
       
         $this->addColumn('id', array(
            'header'        => Mage::helper('codevog_delivery')->__('ID'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));
     $this->addColumn('action', array(
            'header'    => Mage::helper('codevog_delivery')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('codevog_delivery')->__('Edit'),
                    'url'     => array(
                        'base'=>'*/*/editdays',
                    ),
                    'field'   => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'id',
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($days)
    {
        return $this->getUrl('*/*/editdays', array(
            'id' => $days->getId(),
        ));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}