<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Useruploads_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('useruploadsGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('date');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('useruploads_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/useruploads')->getCollection();
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
            'width'         => '80px',
            'filter_index'  => 'ip',
            'index'         => 'ip'
        ));


        $this->addColumn('image', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Image'),
            'align'         => 'center',
            'width'         => '160px',
            'filter_index'  => 'image',
            'index'         => 'image',
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Uploads'
        ));

        $dateStrFormat = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $this->addColumn('date', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Date Of Upload'),
            'align'         => 'left',
            'width'         => '100px',
            'type'          => 'date',
            'filter_index'  => 'date',
            'time' => false,
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'index'         => 'date'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filteruseruploads',array('_current' => true));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('uploads');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('codevog_htmlcanvas')->__('Delete Selected Uploads'),
            'url'      => $this->getUrl('*/*/deleteUseruploads'),
            'selected' => true,
        ));
        return $this;
    }
}