<?php
$this->addAttribute('customer', 'fb_user_id', array(
    'type'      => 'varchar',
    'label'     => 'Facebook User ID',
    'input'     => 'text',
    'position'  => 120,
    'required'  => false,
    'is_system' => 0,
));
$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'fb_user_id');
$attribute->setData('used_in_forms', array(
    'adminhtml_customer',
    'checkout_register',
    'customer_account_create',
    'customer_account_edit',
));
$attribute->setData('is_user_defined', 0);
$attribute->save();

$this->addAttribute('customer', 'fb_access_token', array(
    'type'      => 'varchar',
    'label'     => 'Facebook Access Token',
    'input'     => 'text',
    'position'  => 120,
    'required'  => false,
    'is_system' => 0,
));
$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'fb_access_token');
$attribute->setData('used_in_forms', array(
    'adminhtml_customer',
    'checkout_register',
    'customer_account_create',
    'customer_account_edit',
));
$attribute->setData('is_user_defined', 0);
$attribute->save();
?>