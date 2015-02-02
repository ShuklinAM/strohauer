<?php
class Codevog_Delivery_Block_Adminhtml_Dates_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {

        $this->setId('datesGrid');
        $this->_controller = 'adminhtml_dates';
        $this->setUseAjax(true);
        
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        
    }
 
    protected function _prepareCollection()
    {
       
        $collection = Mage::getModel('delivery/dates')->getCollection()->setOrder('date', 'DESC');
      //  $collection->getSelect()->join(e, 'main_table.entity_id = discount_percents.item_id');
        $this->setCollection($collection);  
      
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    { 
       
        
       $this->addColumn('date', array(
            'header'        => Mage::helper('codevog_delivery')->__('Date'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'date',
            'index'         => 'date'
        ));
        
       
         $this->addColumn('id', array(
            'header'        => Mage::helper('codevog_delivery')->__('ID'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));
     
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($date)
    {
        return $this->getUrl('*/*/editdates', array(
            'id' => $date->getId(),
        ));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}