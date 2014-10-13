<?php

class Codevog_Htmlcanvas_Block_Adminhtml_Editwork extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'codevog_htmlcanvas';
        $this->_mode = 'editwork';
        $this->_controller = 'adminhtml';

        $work_id = (int)$this->getRequest()->getParam('id');


        if($work_id)
        {
            $this->_updateButton('delete','label',Mage::helper('codevog_htmlcanvas')->__('Delete User Work'));
            $this->_updateButton('delete','onclick', "
                    if(confirm('".Mage::helper('codevog_htmlcanvas')->__('Delete Current Work?')."'))
                    {
                        setLocation('".$this->getUrl('*/*/deletework/id/'.$work_id)."')
                    }
                       ");

            //$this->_removeButton('delete');
        }
        $this->_updateButton('back','onclick',"setLocation('".$this->getUrl('*/*/works')."')");

        $work = Mage::getModel('htmlcanvas/works')->load($work_id);

        Mage::register('current_work', $work);

    }

    public function getHeaderText()
    {
        $work = Mage::registry('current_work');
        if ($work->getId()) {
            return Mage::helper('codevog_htmlcanvas')->__("Work In Template Uploads");
        }
//        else {
//            return Mage::helper('codevog_htmlcanvas')->__("Add Size");
//        }
    }
}
?>