<?php
/**
 * PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
 *
 * @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
 * @copyright 2010-9999 VEKIA
 * @license   This program is not free software and you can't resell and redistribute it
 *
 * CONTACT WITH DEVELOPER http://mypresta.eu
 * support@mypresta.eu
 */
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('relatedfree.php');

$relatedfree = new relatedfree();

if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $relatedfree->secure_key)
{
    die(1);
}

if (Tools::isSubmit('relatedfreesubmit'))
{
    Configuration::updateValue('related_category' . Tools::getValue('id_product'), Tools::getValue('related_category'));
    Configuration::updateValue('related_nb' . Tools::getValue('id_product'), Tools::getValue('related_nb'));
    Configuration::updateValue('related_link' . Tools::getValue('id_product'), Tools::getValue('related_link'));
}