<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Subcategories_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setId('subcategoriesGrid');
        //  $this->_controller = 'adminhtml_view';
        $this->setUseAjax(true);

        $this->setDefaultSort('pic_category_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
        $this->setVarNameFilter('subcategories_filter');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('htmlcanvas/picsubcategory')->getCollection();
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



        $categories = Mage::getModel('htmlcanvas/piccategory')->getCollection();
        $categoryList = array();
        foreach($categories as $category)
        {
            $categoryList[$category->getId()] = $category->getName();
        }


        $this->addColumn('pic_category_id', array(
            'header'        => Mage::helper('codevog_htmlcanvas')->__('Category'),
            'align'         => 'left',
            'width'         => '20px',
            'filter_index'  => 'pic_category_id',
            'index'         => 'pic_category_id',
            'type'          => 'options',
            'options'       => $categoryList,
            'renderer'      => 'Codevog_Htmlcanvas_Block_Adminhtml_Renderer_Category'
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
                    'caption' => Mage::helper('codevog_htmlcanvas')->__('Edit Pic Subcategory'),
                    'url'     => array(
                        'base'=>'*/*/editpicsubcategory',
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
        return $this->getUrl('*/*/editpicsubcategory', array(
            'id' => $category->getId(),
        ));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/filterpicssubcategories',array('_current' => true));
    }
}