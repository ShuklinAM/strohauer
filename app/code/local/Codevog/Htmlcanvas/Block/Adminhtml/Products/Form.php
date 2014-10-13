<?php
class Codevog_Htmlcanvas_Block_Adminhtml_Products_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('edit_form', array(
            'legend' => $this->__('Choose Products')
        ));

        $fieldset->addType('categories', 'Codevog_Htmlcanvas_Block_Adminhtml_Products_Categories');

        $fieldset->addField('show_categories', 'categories', array(
            'label'         => '<div id="productsBlock">'.$this->getCategoryHtml().'</div>',
            'name'          => 'show_categories',
            'required'      => false,
            'value'     => $this->__('View Category Products'),

        ));

        $fieldset->addType('products', 'Codevog_Htmlcanvas_Block_Adminhtml_Products_Type');

        $fieldset->addField('show_list', 'products', array(
            'label'         => $this->getLayout()->createBlock('codevog_htmlcanvas/adminhtml_products_list')->toHtml(),
            'name'          => 'show_list',
            'required'      => false,
            'value'     => Mage::helper('codevog_htmlcanvas')->__('Products'),

        ));


        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/saveproducts'));

        $this->setForm($form);

    }

    public function getCategoryHtml()
    {
        $categories = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active')
            ->addFieldToFilter('parent_id', array("gt" => 1))
            ->addAttributeToFilter('is_active', true);

        $html = "<select id='categoryId' onchange=\"viewProductsByCategory(jQuery(this));\">
                                                <option value='0'>--".$this->__('All Products')."--</option>";
        foreach($categories as $category)
        {
            $html .= '<option value="'.$category->getId().'">'.$category->getName().'</option>';
        }
        $html .= '</select>';

        return $html;
    }
}