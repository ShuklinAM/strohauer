<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Categories_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('categoriesGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('position');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('categories_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/piccategory')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Id'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));
        $this->addColumn('name', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Name'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'name',
            'index'         => 'name'
        ));
        $this->addColumn('position', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Position'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'position',
            'index'         => 'position'
        ));


        $this->addColumn('action', array(
            'header'    => Mage::helper('codevog_htmlcanvas')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Edit Pic Category'),
                    'url'     => array(
                        'base'=>'*/*/editpiccategory',
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

    public function getRowUrl($category)
    {
        return $this->getUrl('*/*/editpiccategory', array(
            'id' => $category->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filterpicscategories',array('_current' => true));
    }
}