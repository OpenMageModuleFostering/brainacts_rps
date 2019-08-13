<?php

class AT_Rps_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ENABLED = 'rps/general/enabled';

    const XML_PATH_RESTRICTED_PAYMENT = 'rps/payment/methods';

    const XML_PATH_RESTRICTED_SHIPPING = 'rps/shipping/methods';

    public function isRestrictedPayment($methodCode)
    {
        if (!$this->isActive()) {
            return false;
        }

        $paymentString = Mage::getStoreConfig(self::XML_PATH_RESTRICTED_PAYMENT, Mage::app()->getStore()->getId());
        $payments = explode(',', $paymentString);

        if (is_array($payments) && in_array($methodCode, $payments)) {
            return true;
        } else if ($payments == $methodCode) {
            return true;
        }
        return false;
    }

    public function isActive()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_ENABLED, Mage::app()->getStore()->getId());
    }


    public function isRestrictedShippingMethod($carrierCode, $carrierMethod)
    {
        if (Mage::getDesign()->getArea() === Mage_Core_Model_App_Area::AREA_FRONTEND) {
            $shippingCode = $carrierCode . '_' . $carrierMethod;

            $methodsString = Mage::getStoreConfig(self::XML_PATH_RESTRICTED_SHIPPING, Mage::app()->getStore()->getId());
            $methods = explode(',', $methodsString);

            if (empty($methods)) {
                return false;
            }
            if (is_array($methods) && in_array($shippingCode, $methods)) {
                return true;
            }
        }
        return false;
    }
}