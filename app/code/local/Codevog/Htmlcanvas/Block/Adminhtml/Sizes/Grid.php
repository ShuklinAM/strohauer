<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Sizes_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('sizesGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('position');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('sizes_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/sizes')->getCollection();
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
            'width'         => '150px',
            'filter_index'  => 'name',
            'index'         => 'name'
        ));
        $this->addColumn('price_rule', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Price ('.Mage::helper('codevog_htmlcanvas')->getCurrencySymbol().')'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'price_rule',
            'index'         => 'price_rule'
        ));
        $this->addColumn('shape', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Shape'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'shape',
            'index'         => 'shape',
            'type'          => 'options',
            'options'       => array
                                (
                                    'rectangle' => Mage::helper('codevog_htmlcanvas')->__('Rectangle'),
                                    'oval' => Mage::helper('codevog_htmlcanvas')->__('Oval'),
                                )
        ));
        $this->addColumn('width', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Width (cm)'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'width',
            'index'         => 'width'
        ));
        $this->addColumn('height', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Height (cm)'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'height',
            'index'         => 'height'
        ));

        $this->addColumn('workspace_width', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Workspace Width (cm)'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'workspace_width',
            'index'         => 'workspace_width'
        ));
        $this->addColumn('workspace_height', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Workspace Height (cm)'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'workspace_height',
            'index'         => 'workspace_height'
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
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Edit Size'),
                    'url'     => array(
                        'base'=>'*/*/editsize',
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

    public function getRowUrl($size)
    {
       // $size_id = (int)$this->getRequest()->getParam('id');
        return $this->getUrl('*/*/editsize', array(
            'id' => $size->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filtersizes',array('_current' => true));
    }



}