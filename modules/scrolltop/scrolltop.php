<?php
/*
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-2019 VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER http://mypresta.eu
* support@mypresta.eu
*/

class scrolltop extends Module
{

    public function __construct()
    {
        $this->name = 'scrolltop';
        $this->tab = 'front_office_features';
        $this->version = '1.4.2';
        $this->author = 'mypresta.eu';
        $this->bootstrap = true;
        $this->displayName = $this->l('Scroll to top');
        $this->description = $this->l('Nice and modern button to scroll page to top');
        $this->checkforupdates();
        parent:: __construct();

    }

    public function inconsistency($ret)
    {
        return;
    }

    public function checkforupdates($display_msg = 0, $form = 0)
    {
        // ---------- //
        // ---------- //
        // VERSION 16 //
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
                              F  </button>
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
                        $actual_version = scrolltopUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version);
                    }
                    if (scrolltopUpdate::version($this->version) < scrolltopUpdate::version(Configuration::get('updatev_' . $this->name)) && Tools::getValue('ajax', 'false') == 'false') {
                        $this->context->controller->warnings[] = '<strong>' . $this->displayName . '</strong>: ' . $this->l('New version available, check http://MyPresta.eu for more informations') . ' <a href="' . $this->mypresta_link . '">' . $this->l('More details in changelog') . '</a>';
                        $this->warning = $this->context->controller->warnings[0];
                    }
                } else {
                    if (Configuration::get('update_' . $this->name) < (date("U") - 259200)) {
                        $actual_version = scrolltopUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version);
                    }
                }
                if ($display_msg == 1) {
                    if (scrolltopUpdate::version($this->version) < scrolltopUpdate::version(scrolltopUpdate::verify($this->name, (isset($this->mkey) ? $this->mkey : 'nokey'), $this->version))) {
                        return "<span style='color:red; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('New version available!') . "</span>";
                    } else {
                        return "<span style='color:green; font-weight:bold; font-size:16px; margin-right:10px;'>" . $this->l('Module is up to date!') . "</span>";
                    }
                }
            }
        }
    }

    public function install()
    {
        return parent:: install()
            && $this->registerHook('footer')
            && $this->registerHook('header')
            && Configuration::updateValue('st_color', '1')
            && Configuration::updateValue('st_x', '50px')
            && Configuration::updateValue('st_y', '50px')
            && Configuration::updateValue('st_o', '0.35');
    }


    public function advert()
    {
        return '<iframe src="//apps.facepages.eu/somestuff/whatsgoingon.html" width="100%" height="150" border="0" style="border:none;"></iframe>';
    }

    public function psversion()
    {
        $version = _PS_VERSION_;
        $exp = $explode = explode(".", $version);
        return $exp[1];
    }

    public function myfb()
    {
        return '<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Fmypresta&amp;send=false&amp;layout=button_count&amp;width=120&amp;show_faces=true&amp;font=verdana&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=276212249177933" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; margin-top:10px;" allowTransparency="true"></iframe></div>';
    }


    public function getContent()
    {
        $output = "";

        //categories functions
        if (isset($_POST['module_settings'])) {
            Configuration::updateValue('st_y', Tools::getValue('st_y'));
            Configuration::updateValue('st_x', Tools::getValue('st_x'));
            Configuration::updateValue('st_o', Tools::getValue('st_o'));
            Configuration::updateValue('st_color', Tools::getValue('st_color'));
            $output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="" /></div>';
        }

        $output .= "";
        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        $form = ' <div class="panel">
                <h3>' . $this->l('Settings') . '</h3>
                <form id="settingsform" action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data" style="max-width:400px; display:block; margin:auto;">
                    <div class="panel">
                        <input type="hidden" name="settings" value="1"/>
                        <input type="hidden" name="selecttab" value="5"/>
        				<fieldset style="position:relative;">
        					<div style="display:block; clear:both; text-align:center; overflow:hidden;">
                                <div style="display:block; clear:both; margin-bottom:20px;">
        							<strong>' . $this->l('Color Scheme') . '</strong><br/><br/>
                                    <select name="st_color">
                                        <option value="1" ' . (Configuration::get('st_color') == '1' ? 'selected="yes"' : '') . '>' . $this->l('Dark') . '</option>
                                        <option value="2" ' . (Configuration::get('st_color') == '2' ? 'selected="yes"' : '') . '>' . $this->l('Light') . '</option>
                                    </select>
        		                </div>
                                <div style="display:block; clear:both; margin-bottom:20px;">
                                    <strong>' . $this->l('Opacity') . '</strong><br/><br/>
                                    <input type="text" name="st_o"  value="' . Configuration::get('st_o') . '">
                                </div>
                                <div style="margin:auto; position:relative; background: #FFF url(\'../modules/scrolltop/position.png\') no-repeat center; display:block; clear:both; margin-bottom:20px; width:200px; height:200px; padding:10px; border:1px solid black;">
        							<strong>' . $this->l('definie position') . '</strong><br/><br/>
                                    <input type="text" name="st_x"  value="' . Configuration::get('st_x') . '" style="position:absolute; bottom:40px; left:40px; width:40px;">
                                    <input type="text" name="st_y"  value="' . Configuration::get('st_y') . '" style="position:absolute; top:40px; right: 40px; width:40px;">
        		                </div>
                                <div style="margin-top:20px; clear:both; overflow:hidden; display:block; text-align:center" class="panel-footer">
                	               <input type="submit" name="module_settings" class="btn btn-default" value="' . $this->l('save') . '">
                	            </div>
        	                </div>
                       </fieldset>
                    </div>
               </form>
               </div>
               ';

        return $this->advert() . $form . $this->checkforupdates(0, 1) . $this->myfb();
    }

    public function hookHeader($params)
    {
        if ($this->psversion() == 5 || $this->psversion() == 6 || $this->psversion() == 7) {
            $this->context->controller->addCSS(($this->_path) . 'scrolltop.css', 'all');
            $this->context->controller->addJS(($this->_path) . 'scrolltop.js', 'all');
        } else {
            Tools::addCSS(($this->_path) . 'scrolltop.css');
            Tools::addJS(($this->_path) . 'scrolltop.js');
        }
    }


    // HOOKS
    public function hookFooter($params)
    {
        global $smarty;
        if ($this->psversion() == 5 || $this->psversion() == 6 || $this->psversion() == 7) {
            $smarty->assign(array('url' => $this->context->link->protocol_content . Tools::getMediaServer($this->name) . _MODULE_DIR_ . $this->name . '/'));
            $smarty->assign(array('stx' => Configuration::get('st_x')));
            $smarty->assign(array('sto' => Configuration::get('st_o')));
            $smarty->assign(array('sty' => Configuration::get('st_y')));
            $smarty->assign(array('stc' => Configuration::get('st_color')));

        } else {
            $this->context = new StdClass();
            $this->context->link = new Link();
            $smarty->assign(array('url' => $this->context->link->protocol_content . _MODULE_DIR_ . $this->name . '/'));
            $smarty->assign(array('stx' => Configuration::get('st_x')));
            $smarty->assign(array('sto' => Configuration::get('st_o')));
            $smarty->assign(array('sty' => Configuration::get('st_y')));
            $smarty->assign(array('stc' => Configuration::get('st_color')));
        }


        return $this->display(__FILE__, 'footer.tpl');
    }

}

class scrolltopUpdate extends scrolltop
{
    public static function version($version)
    {
        $version = (int)str_replace(".", "", $version);
        if (strlen($version) == 3) {
            $version = (int)$version . "0";
        }
        if (strlen($version) == 2) {
            $version = (int)$version . "00";
        }
        if (strlen($version) == 1) {
            $version = (int)$version . "000";
        }
        if (strlen($version) == 0) {
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
        if (ini_get("allow_url_fopen")) {
            if (function_exists("file_get_contents")) {
                $actual_version = @file_get_contents('http://dev.mypresta.eu/update/get.php?module=' . $module . "&version=" . self::encrypt($version) . "&lic=$key&u=" . self::encrypt(_PS_BASE_URL_ . __PS_BASE_URI__));
            }
        }
        Configuration::updateValue("update_" . $module, date("U"));
        Configuration::updateValue("updatev_" . $module, $actual_version);

        return $actual_version;
    }
}