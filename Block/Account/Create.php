<?php
class Cammino_Sociallogin_Block_Account_Create extends Mage_Core_Block_Template {

	private $_password;

	public function __construct() {
		$this->_password = Mage::helper('core')->getRandomString($length = 20);
	}

	public function getEmail() {
		return $this->getSession()->getFbEmail();
	}

	public function getName() {
		return $this->getSession()->getFbName();
	}

	public function getFirstname() {
		return $this->getSession()->getFbFirstname();
	}

	public function getLastname() {
		$fullname = $this->getName();
		$firstname = $this->getFirstname();
		$lastname = trim(str_replace($firstname, '', $fullname));
		return $lastname;
	}

	public function getPassword() {
		return $this->_password;
	}

	public function getUserId() {
		return $this->getSession()->getFbUserId();
	}

	public function getAccessToken() {
		return $this->getSession()->getFbAccessToken();
	}

	private function getSession() {
		return Mage::getModel('core/session');
	}

}