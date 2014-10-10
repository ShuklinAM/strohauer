<?php
class Codevog_Htmlcanvas_Block_Adminhtml_About_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('aboutGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('about_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/about')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Name'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'name',
            'index'         => 'name'
        ));
        $this->addColumn('alias', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Alias'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'alias',
            'index'         => 'alias'
        ));
        $this->addColumn('text', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Message'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'text',
            'index'         => 'text'
        ));


        $this->addColumn('action', array(
            'header'    => Mage::helper('codevog_htmlcanvas')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Edit Message'),
                    'url'     => array(
                        'base'=>'*/*/editabout',
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

    public function getRowUrl($about)
    {
        return $this->getUrl('*/*/editabout', array(
            'id' => $about->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filterabout',array('_current' => true));
    }
}