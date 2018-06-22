<?php
class Cammino_Sociallogin_Model_Observer extends Varien_Object {

	public function clearSessionData(Varien_Event_Observer $observer) {
		Mage::getModel('core/session')->unsFbName();
		Mage::getModel('core/session')->unsFbFirstname();
		Mage::getModel('core/session')->unsFbEmail();
		Mage::getModel('core/session')->unsFbAccessToken();
		Mage::getModel('core/session')->unsFbUserId();
	}
	
}