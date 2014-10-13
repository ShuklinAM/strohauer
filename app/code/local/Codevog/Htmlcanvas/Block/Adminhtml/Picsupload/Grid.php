<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Picsupload_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('picsuploadGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('pic_subcategory_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('pics_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/pics')->getCollection();
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



        $subcategories = Mage::getModel('htmlcanvas/picsubcategory')->getCollection();
        $subcategoryList = array();
        foreach($subcategories as $subcategory)
        {
            $subcategoryList[$subcategory->getId()] = $subcategory->getName();
        }


        $this->addColumn('pic_subcategory_id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Subcategory'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'pic_subcategory_id',
            'index'         => 'pic_subcategory_id',
            'type'          => 'options',
            'options'       => $subcategoryList,
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Subcategory'
        ));

        $this->addColumn('pic', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Pic'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'pic',
            'index'         => 'pic',
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Pic'
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
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Edit Pic'),
                    'url'     => array(
                        'base'=>'*/*/editpicupload',
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

    public function getRowUrl($pic)
    {
        return $this->getUrl('*/*/editpicupload', array(
            'id' => $pic->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filterpicsupload',array('_current' => true));
    }
}