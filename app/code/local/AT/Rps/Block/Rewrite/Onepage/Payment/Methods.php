<?php

class AT_Rps_Block_Rewrite_Onepage_Payment_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{
    protected function _canUseMethod($method)
    {
        /** @var AT_Rps_Helper_Data $helper */
        $helper = Mage::helper('rps');
        if ($helper->isRestrictedPayment($method->getCode())) {
            return false;
        }
        return $method && $method->canUseCheckout() && parent::_canUseMethod($method);
    }
}

