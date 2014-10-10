<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Works_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('worksGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('done');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('works_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/works')->getCollection();
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
        $this->addColumn('ip', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Ip'),
            'align'         => 'left',
            'width'         => '50px',
            'filter_index'  => 'ip',
            'index'         => 'ip'
        ));
        $this->addColumn('image', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Image'),
            'align'         => 'center',
            'width'         => '160px',
            'filter_index'  => 'image',
            'index'         => 'image',
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Work'
        ));
        $this->addColumn('done', array(
            'header'    => Mage::helper('codevog_htmlcanvas')->__('In Order'),
            'align'     => 'left',
            'width'     => '30px',
            'index'     => 'done',
            'type'      => 'options',
            'options'   => array(
                0 => 'No',
                1 => 'Yes',
            ),
        ));
        $this->addColumn('show_template', array(
            'header'    => Mage::helper('codevog_htmlcanvas')->__('Show In Uploads'),
            'align'     => 'left',
            'width'     => '20px',
            'index'     => 'show_template',
            'type'      => 'options',
            'options'   => array(
                0 => 'No',
                1 => 'Yes',
            ),
        ));
        $sizes = Mage::getModel('htmlcanvas/sizes')->getCollection();
        $sizesList = array();
        foreach($sizes as $size)
        {
            $sizesList[$size->getId()] = $size->getName();
        }


        $this->addColumn('size_id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Size'),
            'align'         => 'left',
            'width'         => '100px',
            'filter_index'  => 'size_id',
            'index'         => 'size_id',
            'type'          => 'options',
            'options'       => $sizesList,
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Size'
        ));
        $this->addColumn('order_id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Order Id'),
            'align'         => 'left',
            'width'         => '30px',
            'filter_index'  => 'order_id',
            'index'         => 'order_id'
        ));
        $this->addColumn('item_id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Item Id'),
            'align'         => 'left',
            'width'         => '30px',
            'filter_index'  => 'item_id',
            'index'         => 'item_id'
        ));



        $dateStrFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $this->addColumn('create_date', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Date Of Create'),
            'align'         => 'left',
            'width'         => '20px',
            'type'          => 'date',
            'filter_index'  => 'create_date',
            'time' => false,
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'index'         => 'create_date'
        ));
        $this->addColumn('last_update', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Date Of Last Update'),
            'align'         => 'left',
            'width'         => '20px',
            'type'          => 'date',
            'filter_index'  => 'last_update',
            'time' => false,
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'index'         => 'last_update'
        ));
        $this->addColumn('action', array(
            'header'    => Mage::helper('codevog_htmlcanvas')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Preview Work'),
                    'url'     => array(
                        'base'=>'*/*/editwork',
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

    public function getRowUrl($work)
    {
        // $size_id = (int)$this->getRequest()->getParam('id');
        return $this->getUrl('*/*/editwork', array(
            'id' => $work->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filterworks',array('_current' => true));
    }
}