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

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class relatedfree extends Module
{
    public function __construct()
    {
        $this->name = 'relatedfree';
        $this->tab = 'advertising_marketing';
        $this->author = 'MyPresta.eu';
        $this->mypresta_link = 'https://mypresta.eu/modules/front-office-features/related-products-free.html';
        $this->version = '1.6.3';
        $this->module_key = 'de6f0cf17c8cb0d314ec544203a9f5f5';
        $this->bootstrap = true;
        parent::__construct();
        $this->secure_key = Tools::encrypt($this->name);
        $this->displayName = $this->l('Related products free');
        $this->description = $this->l('Module allows to display custom related products block with products from selected category');
        $this->checkforupdates(0,0);
    }

    public function psversion($part = 1)
    {
        $version = _PS_VERSION_;
        $exp = $explode = explode(".", $version);
        if ($part == 1)
        {
            return $exp[1];
        }
        if ($part == 2)
        {
            return $exp[2];
        }
        if ($part == 3)
        {
            return $exp[3];
        }
    }

    public function hookactionAdminControllerSetMedia($params)
    {
        //for update feature purposes
    }

    public function return_rf_tpath()
    {
        $rf_tpath = Configuration::get('rf_tpath');
        if ($rf_tpath != '' && $rf_tpath != false) {
            return $rf_tpath;
        } else {
            return 'catalog/_partials/miniatures/product.tpl';
        }
    }

    public function checkforupdates($display_msg = 0, $form = 0)
    {
        // ---------- //
        // ---------- //
        // VERSION 14 //
        // ---------- //
        // ---------- //
        $this->mkey = "nlc";
        if (@file_exists('../modules/' . $this->name . '/key.php')) {
            @require_once('../modules/' . $this->name . '/key.php');
        } else {
            if (@file_exists(dirname(__FILE__) . $this->name . '/key.php')) {
                @require_once(dirname(__FILE__) . $this->name . '/key.php');
            } else {
                if (@file_exists('modules/' . $this->name . '/key.php')) {
                    @require_once('modules/' . $this->name . '/key.php');
                }
            }
        }
        if ($form == 1) {
            return '
            <div class="panel" id="fieldset_myprestaupdates" style="margin-top:20px;">
            ' . ($this->psversion() == 6 || $this->psversion() == 7 ? '<div class="panel-heading"><i class="icon-wrench"></i> ' . $this->l('MyPresta updates') . '</div>' : '') . '
			<div class="form-wrapper" style="padding:0px!important;">
            <div id="module_block_settings">
                    <fieldset id="fieldset_module_block_settings">
                         ' . ($this->psversion() == 5 ? '<legend style="">' . $this->l('MyPresta updates') . '</legend>' : '') . '
                        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                            <label>' . $this->l('Check updates') . '</label>
                            <div class="margin-form">' . (Tools::isSubmit('submit_settings_updates_now') ? ($this->inconsistency(0) ? '' : '') . $this->checkforupdates(1) : '') . '
                                <button style="margin: 0px; top: -3px; position: relative;" type="submit" name="submit_settings_updates_now" class="button btn btn-default" />
                                <i class="process-icon-update"></i>
                                ' . $this->l('Check now') . '
                                </button>
                            </div>
                            <label>' . $this->l('Updates notifications') . '</label>
                            <div class="margin-form">
                                <select name="mypresta_updates">
                                    <option value="-">' . $this->l('-- select --') . '</option>
                                    <option value="1" ' . ((int)(Configuration::get('mypresta_updates') == 1) ? 'selected="selected"' : '') . '>' . $this->l('Enable') . '</option>
                                    <option value="0" ' . ((int)(Configuration::get('mypresta_updates') == 0) ? 'selected="selected"' : '') . '>' . $this->l('Disable') . '</option>
                                </select>
                                <p class="clear">' . $this->l('Turn this option on if you want to check MyPresta.eu for module updates automatically. This option will display notification about new versions of this addon.') . '</p>
                            </div>
                            <label>' . $this->l('Module page') . '</label>
                            <div class="margin-form">
                                <a style="font-size:14px;" href="' . $this->mypresta_link . '" target="_blank">' . $this->displayName . '</a>
                                <p class="clear">' . $this->l('This is direct link to official addon page, where you can read about changes in the module (changelog)') . '</p>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" name="submit_settings_updates"class="button btn btn-default pull-right" />
                                <i class="process-icon-save"></i>
                                ' . $this->l('Save') . '
                                </button>
                            </div>
                        </form>
                    </fieldset>
                    <style>
                    #fieldset_myprestaupdates {
                        display:block;clear:both;
                        float:inherit!important;
                    }
                    </style>
                </div>
            </div>
            </div>';
        } else {
            if (defined('_PS_ADMIN_DIR_')) {
                if (Tools::isSubmit('submit_settings_updates')) {
                    Configuration::updateValue('mypresta_updates', Tools::getValue('mypresta_updates'));
                }
                if (Configuration::get('mypresta_updates') != 0 || (bool)Configuration::get('mypresta_updates') != false) {
                    if (Configuration::get('update_' . $this->name) < (date("U") - 259200)) {
                        $actual_version = relatedfreeUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version);
                    }
                    if (relatedfreeUpdate::version($this->version) < relatedfreeUpdate::version(Configuration::get('updatev_' . $this->name))) {
                        $this->context->controller->warnings[] = '<strong>' . $this->displayName . '</strong>: ' . $this->l('New version available, check http://MyPresta.eu for more informations') . ' <a href="' . $this->mypresta_link . '">' . $this->l('More details in changelog') . '</a>';
                        $this->warning                         = $this->context->controller->warnings[0];
                    }
                }
                if ($display_msg == 1) {
                    if (relatedfreeUpdate::version($this->version) < relatedfreeUpdate::version(relatedfreeUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version))) {
                        return "<span style='color:red; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('New version available!') . "</span>";
                    } else {
                        return "<span style='color:green; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('Module is up to date!') . "</span>";
                    }
                }
            }
        }
    }

    public function getContent()
    {
        if (Tools::isSubmit('btnSubmit')){
            Configuration::updateValue('rf_tpath', Tools::getValue('rf_tpath', 'catalog/_partials/miniatures/product.tpl'));
            Configuration::updateValue('rf_maincss', Tools::getValue('rf_maincss', 'featured-products clearfix'));
            Configuration::updateValue('rf_productscss', Tools::getValue('rf_productscss', 'products row'));
            $this->context->controller->confirmations[] = $this->l('Settings saved');
        }
        return $this->renderForm().$this->checkforupdates(0, 1);
    }

    public function install()
    {
        if (parent::install() == false or
            !Configuration::updateValue('rf_tpath', 'catalog/_partials/miniatures/product.tpl') or
            !Configuration::updateValue('rf_maincss', 'featured-products clearfix') or
            !Configuration::updateValue('rf_productscss', 'products row') or
            !$this->registerHook('displayHeader') or
            !$this->registerHook('productFooter') or
            !$this->registerHook('displayAdminProductsExtra') or
            !$this->registerHook('displayProductTab') or
            !$this->registerHook('displayProductTabContent') or
            !$this->registerHook('actionProductUpdate'))
        {
            return false;
        }
        return true;
    }

    public function hookActionProductUpdate($params)
    {
        if (Tools::isSubmit('relatedfree'))
        {
            Configuration::updateValue('related_category' . Tools::getValue('id_product'), Tools::getValue('related_category'));
            Configuration::updateValue('related_nb' . Tools::getValue('id_product'), Tools::getValue('related_nb'));
            Configuration::updateValue('related_link' . Tools::getValue('id_product'), Tools::getValue('related_link'));
        }
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend'      => array(
                    'title' => $this->l('Settings of the module'),
                    'icon'  => 'icon-cubes',
                ),
                'description' => $this->l('With this form you will configure global settings of the module. If you are looking for form to define "related products" - you can find it on each product edit page (there is a section with modules where you can manage this module settings)'),
                'input'       => array(
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Path to .tpl file of product miniature'),
                        'name'  => 'rf_tpath',
                        'desc'  => $this->l('default value for Prestashop 1.7 classic theme: catalog/_partials/miniatures/product.tpl') . '<br/>' . $this->l('If you want to use non-default path - make sure that this file exists, otherwise website will spawn error about "unable to load template file"') . '<div class="alert alert-info">' . $this->l('Module to build list of products will use theme file that is responsible for "miniature" of product on list of products. If your theme does not follow prestashop standards and uses own not-default .tpl files - you can type here the path to this .tpl file. This option makes the module compatible with all themes.') . '</div>',
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('CSS class of main div with products'),
                        'name'  => 'rf_maincss',
                        'desc'  => $this->l('default value for Prestashop 1.7 classic theme: "featured-products clearfix"'),
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('CSS class of block with products'),
                        'name'  => 'rf_productscss',
                        'desc'  => $this->l('default value for Prestashop 1.7 classic theme: "products row"'),
                    ),
                ),
                'submit'      => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper                           = new HelperForm();
        $helper->default_form_language    = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier               = 'rf_settings';
        $helper->submit_action            = 'btnSubmit';
        $helper->currentIndex             = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token                    = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars                 = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages'    => $this->context->controller->getLanguages(),
            'id_language'  => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'rf_tpath' => Tools::getValue('ppb_customtplpath', $this->return_rf_tpath()),
            'rf_maincss' => Tools::getValue('rf_maincss', Configuration::get('rf_maincss')),
            'rf_productscss' => Tools::getValue('rf_productscss', Configuration::get('rf_productscss')),
        );
    }    

    public function hookDisplayAdminProductsExtra($params)
    {
        $_GET['id_product'] = $params['id_product'];
        $this->context->smarty->assign('id_product', Tools::getValue('id_product'));
        $this->context->smarty->assign('related_category', Configuration::get('related_category' . Tools::getValue('id_product')));
        $this->context->smarty->assign('related_nb', Configuration::get('related_nb' . Tools::getValue('id_product')));
        $this->context->smarty->assign('related_link', Configuration::get('related_link' . Tools::getValue('id_product')));
        $this->context->smarty->assign('physical_uri', $this->context->shop->physical_uri);
        $this->context->smarty->assign('virtual_uri', $this->context->shop->virtual_uri);
        $this->context->smarty->assign('secure_key', $this->secure_key);
        return $this->display(__FILE__, 'views/templates/admin/tabs.tpl');
    }

    public function hookProductFooter($params)
    {
        $category = new Category(Configuration::get('related_category' . Tools::getValue('id_product')));
        $blocks_products = $category->getProducts($this->context->cookie->id_lang, 0, Configuration::get('related_nb' . Tools::getValue('id_product')));
        $products = $this->prepareBlocksProducts($blocks_products);
        $this->context->smarty->assign('related_link', Configuration::get('related_link' . Tools::getValue('id_product')));
        $this->context->smarty->assign('related_category', Configuration::get('related_category' . Tools::getValue('id_product')));
        $this->context->smarty->assign('related_nb', Configuration::get('related_nb' . Tools::getValue('id_product')));
        $this->context->smarty->assign('products', $products);
        $this->context->smarty->assign('rf_tpath', $this->return_rf_tpath());
        $this->context->smarty->assign('rf_maincss', Configuration::get('rf_maincss'));
        $this->context->smarty->assign('rf_productscss', Configuration::get('rf_productscss'));

        return $this->context->smarty->fetch('module:relatedfree/views/templates/hook/productFooter.tpl');
    }

    public function prepareBlocksProducts($products)
    {
        if ($products != false)
        {
            $products_for_template = [];
            $assembler = new ProductAssembler($this->context);
            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(new ImageRetriever($this->context->link), $this->context->link, new PriceFormatter(), new ProductColorsRetriever(), $this->context->getTranslator());
            $products_for_template = [];
            foreach ($products as $rawProduct)
            {
                $products_for_template[] = $presenter->present($presentationSettings, $assembler->assembleProduct($rawProduct), $this->context->language);
            }

            return $products_for_template;
        }
        else
        {
            return false;
        }
    }
}

class relatedfreeUpdate extends relatedfree
{
    public static function version($version)
    {
        $version = (int)str_replace(".", "", $version);
        if (strlen($version) == 3)
        {
            $version = (int)$version . "0";
        }
        if (strlen($version) == 2)
        {
            $version = (int)$version . "00";
        }
        if (strlen($version) == 1)
        {
            $version = (int)$version . "000";
        }
        if (strlen($version) == 0)
        {
            $version = (int)$version . "0000";
        }
        return (int)$version;
    }

    public static function encrypt($string)
    {
        return base64_encode($string);
    }

    public static function verify($module, $key, $version)
    {
        if (ini_get("allow_url_fopen"))
        {
            if (function_exists("file_get_contents"))
            {
                $actual_version = @file_get_contents('http://dev.mypresta.eu/update/get.php?module=' . $module . "&version=" . self::encrypt($version) . "&lic=$key&u=" . self::encrypt(_PS_BASE_URL_ . __PS_BASE_URI__));
            }
        }
        Configuration::updateValue("update_" . $module, date("U"));
        Configuration::updateValue("updatev_" . $module, $actual_version);
        return $actual_version;
    }
}
?>