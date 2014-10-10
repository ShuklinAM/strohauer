<?php
class Codevog_Templatesettings_AjaxController extends Mage_Core_Controller_Front_Action
{

   public function loginformAction()
   {
       if(Mage::getStoreConfig('templatesettings/templatesettings_header/top_ajaxlogin'))
       {
           $this->getResponse()->setHeader('Login-Required', 'true');
           $this->loadLayout();
           $this->_initLayoutMessages('customer/session');
           $this->_initLayoutMessages('catalog/session');
           $this->renderLayout();
       }
       else
           return false;
   }
    public function registerformAction()
    {
        if(Mage::getStoreConfig('templatesettings/templatesettings_header/top_ajaxsignup'))
        {
            $this->loadLayout();
            $this->_initLayoutMessages('customer/session');
            $this->renderLayout();
        }
        else
            return false;
    }




    /*Cart ajax functions*/

    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
    protected function _initProduct()
    {
        $productId = (int) $this->getRequest()->getParam('product');
        if ($productId) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($productId);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }

    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }



    public function addtocartAction()
    {

        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();

            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
               // $this->_goBack();
                return false;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );


        $this->loadLayout();
        $this->renderLayout();

    }
    public function  showcartAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function updatecartAction()
    {
        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');

        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
                $this->_updateShoppingCart();
                break;
            default:
                $this->_updateShoppingCart();
        }
        $this->loadLayout();
        $this->renderLayout();
       // var_dump($updateAction);
    }

    protected function _updateShoppingCart()
    {
        try {
            $cartData = $this->getRequest()->getParam('cart');
            if (is_array($cartData)) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                foreach ($cartData as $index => $data) {
                    if (isset($data['qty'])) {
                        $cartData[$index]['qty'] = $filter->filter(trim($data['qty']));
                    }
                }
                $cart = $this->_getCart();
                if (! $cart->getCustomerSession()->getCustomer()->getId() && $cart->getQuote()->getCustomerId()) {
                    $cart->getQuote()->setCustomerId(null);
                }

                $cartData = $cart->suggestItemsQty($cartData);
                $cart->updateItems($cartData)
                    ->save();
            }
            $this->_getSession()->setCartWasUpdated(true);
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError(Mage::helper('core')->escapeHtml($e->getMessage()));
        } catch (Exception $e) {
            $this->_getSession()->addException($e, $this->__('Cannot update shopping cart.'));
            Mage::logException($e);
        }
    }

    /**
     * Empty customer's shopping cart
     */
    protected function _emptyShoppingCart()
    {
        try {
            $this->_getCart()->truncate()->save();
            $this->_getSession()->setCartWasUpdated(true);
        } catch (Mage_Core_Exception $exception) {
            $this->_getSession()->addError($exception->getMessage());
        } catch (Exception $exception) {
            $this->_getSession()->addException($exception, $this->__('Cannot update shopping cart.'));
        }
    }

    public function deletecartAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_getCart()->removeItem($id)
                    ->save();
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Cannot remove the item.'));
                Mage::logException($e);
            }
        }
        $this->loadLayout();
        $this->renderLayout();
    }
    /*end cart ajax*/
}