<?php
class Codevog_Delivery_Block_Adminhtml_Minimumdays_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
    
        $this->setId('minimumdaysGrid');
        $this->_controller = 'adminhtml_minimumdays';
        $this->setUseAjax(true);
        
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        
    }
 
    protected function _prepareCollection()
    {
     
        $collection = Mage::getModel('delivery/minimumdays')->getCollection();
      //  $collection->getSelect()->join(e, 'main_table.entity_id = discount_percents.item_id');
        $this->setCollection($collection);  
      
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    { 
      
        
       /*$this->addColumn('id', array(
            'header'        => Mage::helper('codevog_delivery')->__('ID'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));*/
        $this->addColumn('num', array(
          'header'    => Mage::helper('codevog_delivery')->__('Num of days'),
          'width'     => '80px',
          'index'     => 'num',
          'align'     => 'left'
          
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
                        'base'=>'*/*/editminimumdays',
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
 
    public function getRowUrl($minimumdays)
    {
        return $this->getUrl('*/*/editminimumdays', array(
            'id' => $minimumdays->getId(),
        ));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}