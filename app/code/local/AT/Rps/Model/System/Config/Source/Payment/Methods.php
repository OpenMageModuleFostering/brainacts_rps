<?php

class AT_Rps_Model_System_Config_Source_Payment_Methods
{
    public function toOptionArray()
    {
        $store = null;
        $websiteCode = Mage::app()->getRequest()->getParam('website', false);
        if ($websiteCode) {
            /** @var Mage_Core_Model_Website $website */
            $website = Mage::getModel('core/website')->load($websiteCode);
            $store = $website->getDefaultStore();
        }

        /** @var Mage_Payment_Model_Config $configModel */
        $configModel = Mage::getSingleton('payment/config');

        $payments = $configModel->getActiveMethods($store);

        $methods = array(array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- None --')));

        foreach ($payments as $paymentCode => $paymentModel) {

            $paymentTitle = Mage::getStoreConfig('payment/' . $paymentCode . '/title');

            if ($paymentCode == 'free') {
                continue; //skip free method as block this method could create issue on frontend
            }

            $methods[$paymentCode] = array(
                'label' => $paymentTitle,
                'value' => $paymentCode,
            );
        }

        return $methods;
    }

}