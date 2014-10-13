<?php
class Codevog_News_Block_Adminhtml_View_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('newsGrid');
      //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('start_date');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('news_filter');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('news/news')->getCollection();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('id', array(
            'header'        => Mage::helper('codevog_news')->__('Id'),
            'align'         => 'right',
            'width'         => '20px',
            'filter_index'  => 'id',
            'index'         => 'id'
        ));
        $this->addColumn('name', array(
            'header'        => Mage::helper('codevog_news')->__('Name'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'name',
            'index'         => 'name'
        ));
        $this->addColumn('title', array(
            'header'        => Mage::helper('codevog_news')->__('Header'),
            'align'         => 'left',
            'width'         => '120px',
            'filter_index'  => 'title',
            'index'         => 'title'
        ));
        $this->addColumn('image', array(
            'header'        => Mage::helper('codevog_news')->__('Image name'),
            'align'         => 'left',
            'width'         => '120px',
            'filter_index'  => 'image',
            'index'         => 'image'
        ));
        $dateStrFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $this->addColumn('start_date', array(
            'header'        => Mage::helper('codevog_news')->__('Start date'),
            'align'         => 'left',
            'width'         => '120px',
            'type'          => 'date',
            'filter_index'  => 'start_date',
            'time' => true,
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'index'         => 'start_date'
        ));
        $this->addColumn('finish_date', array(
            'header'        => Mage::helper('codevog_news')->__('Finish date'),
            'align'         => 'left',
            'width'         => '120px',
            'type'          => 'date',
            'filter_index'  => 'finish_date',
            'time' => true,
            'format'    => $dateStrFormat,
            'no_span'   => true,
            'index'         => 'finish_date'
        ));
        $this->addColumn('enabled', array(
            'header'    => Mage::helper('codevog_news')->__('Enabled'),
            'align'     => 'left',
            'index'     => 'enabled',
            'type'      => 'options',
            'options'   => array(
                0 => 'No',
                1 => 'Yes',
            ),
        ));


        $this->addColumn('action', array(
            'header'    => Mage::helper('codevog_news')->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'     => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('codevog_news')->__('Edit news'),
                    'url'     => array(
                        'base'=>'*/*/editnews',
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

    public function getRowUrl($news)
    {
        $frame_id = (int)$this->getRequest()->getParam('id');
        return $this->getUrl('*/*/editnews', array(
            'id' => $news->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid',array('_current' => true));
    }
}