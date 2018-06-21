<?php
class Cammino_Sociallogin_LoginController extends Mage_Core_Controller_Front_Action
{
	public function checkAction() {
		$fbUserId = $this->getFbUserId();
		$storeId = Mage::app()->getWebsite()->getId();
		$users = $this->getCustomerByFbUserId($storeId, $fbUserId);
		$redirectUrl = '';

		if (count($users) > 0) {
			$this->doLogin(end($users), $storeId);
			$redirectUrl = Mage::getUrl('customer/account', array('_secure' => true));
		} else {
			$this->saveFbDataInSession($fbUserId);
			$redirectUrl = Mage::getUrl('customer/account/create', array('_secure' => true));
		}

		header('Content-Type: application/json');
		echo json_encode(array('redirectUrl' => $redirectUrl));
	}

	private function parseSignedRequest($signedRequest) {
		list($encodedSig, $payload) = explode('.', $signedRequest, 2);

		$secret = "85c27caabe8b06fbea76753fcaf9256c"; // config
		$sig = $this->base64UrlDecode($encodedSig);
		$data = json_decode($this->base64UrlDecode($payload), true);
		$expectedSig = hash_hmac('sha256', $payload, $secret, $raw = true);

		if ($sig !== $expectedSig) {
			return null;
		}

		return $data;
	}

	private function base64UrlDecode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}

	private function getCustomerByFbUserId($storeId, $fbUserId) {
		$users = Mage::getResourceModel('customer/customer_collection')
			->addAttributeToFilter('store_id', $storeId)
			->addFieldToFilter('fb_user_id', array('eq' => $fbUserId))
			->getItems();

		return $users;
	}

	private function saveFbDataInSession($fbUserId) {
		$fbEmail = $this->getRequest()->getParam('email');
		$fbAccessToken = $this->getRequest()->getParam('accessToken');
		$fbName = $this->getRequest()->getParam('name');
		$fbFirstName = $this->getRequest()->getParam('firstName');
		
		Mage::getModel('core/session')->setFbName($fbName);
		Mage::getModel('core/session')->setFbFirstname($fbFirstName);
		Mage::getModel('core/session')->setFbEmail($fbEmail);
		Mage::getModel('core/session')->setFbAccessToken($fbAccessToken);
		Mage::getModel('core/session')->setFbUserId($fbUserId);
	}

	private function getFbUserId() {
		$fbSignedRequest = $this->getRequest()->getParam('signedRequest');
		$signedRequestData = $this->parseSignedRequest($fbSignedRequest);
		return $signedRequestData['user_id'];
	}

	private function doLogin($user, $storeId) {
		$customer = Mage::getModel('customer/customer')->setWebsiteId($storeId)->load($user->getId());
		$session = Mage::getSingleton('customer/session');
		$session->setCustomerAsLoggedIn($customer);
	}

}
?>