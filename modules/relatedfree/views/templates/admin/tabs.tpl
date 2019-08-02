{**
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-2016 VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER http://mypresta.eu
* support@mypresta.eu
*}

<div class="panel " id="relatedFreeDiv">
    <input type="hidden" name="relatedfree" value="1"/>
    <h2 class="tab">{l s='Related products free' d='Module.RelatedFree.Admin'}</h2>
    <div class="separation"></div>
    <table>
        <td><img src="../../../../modules/relatedfree/related-pro.png" class="img-responsive"/></td>
        <td style="width:20px;"></td>
        <td>
            1. {l s='Want much more appearance options?' d='Module.RelatedFree.Admin'}<br/>
            2. {l s='Want to display products in random order?' d='Module.RelatedFree.Admin'}<br/>
            3. {l s='Want to display custom selected products only?' d='Module.RelatedFree.Admin'}<br/>
            4. {l s='Want to display list of products in "tabs" section?' d='Module.RelatedFree.Admin'}<br/>
            5. {l s='Want to display unlimited number of blocks?' d='Module.RelatedFree.Admin'}<br/>
            6. {l s='Want to create related products carousell?' d='Module.RelatedFree.Admin'}<br/>
            7. {l s='Want the best related products tool?' d='Module.RelatedFree.Admin'}<br/>
            <span style="font-size:18px;">{l s='check' d='Module.RelatedFree.Admin'} <a href="http://mypresta.eu/modules/front-office-features/related-products-pro.html" target="_blank">related products pro</a> {l s='module' d='Module.RelatedFree.Admin'}.</span>
        </td>
    </table>
    <h2 class="tab">{l s='Module Settings' d='Module.RelatedFree.Admin'}</h2>
    <fieldset style="border:none;">
        <div class="alert alert-info">
            <i class="material-icons">help</i>
            <p class="alert-text">
                {l s='Category ID' d='Module.RelatedFree.Admin'}<br>
                <a href="https://mypresta.eu/en/art/basic-tutorials/prestashop-how-to-get-category-id.html" target="_blank">{l s='How to get category ID ?' d='Module.RelatedFree.Admin'}</a>
            </p>
        </div>
        <div class="form_block">
            <div>
                {l s='Category ID' d='Module.RelatedFree.Admin'}
                <input type="text" name="related_category" id="related_category" class="ex_search form-control" value="{$related_category|escape:'int':'utf-8'}"/>
            </div>
        </div>

        <div class="alert alert-info">
            <i class="material-icons">help</i>
            <p class="alert-text">
                {l s='Number of products' d='Module.RelatedFree.Admin'}<br>
                {l s='Define how many products will appear inside product block' d='Module.RelatedFree.Admin'}
            </p>
        </div>
        <div class="form_block">
            <div>
                {l s='Number of products ' d='Module.RelatedFree.Admin'}
                <input type="text" name="related_nb" id="related_nb" value="{$related_nb|escape:'int':'utf-8'}" class="ex_search form-control"/>
            </div>
        </div>


        <div class="form_block">
            <div>
                {l s='Add category link to title of block' d='Module.RelatedFree.Admin'}
                <select name="related_link" id="related_link">
                    <option value="1" {if $related_link == 1}selected{/if}>{l s='Yes' d='Module.RelatedFree.Admin'}</option>
                    <option value="0" {if $related_link == 0}selected{/if}>{l s='No' d='Module.RelatedFree.Admin'}</option>
                </select>
            </div>
        </div>
        <div class="separation"></div>
        <script>
            {literal}
                function submitRelatedFreeForm(){
                    var order = "&id_product={/literal}{$id_product}{literal}&relatedfreesubmit=1&secure_key={/literal}{$secure_key}{literal}&related_nb="+$('#related_nb').val()+"&related_category="+$('#related_category').val()+"&related_link="+$('#related_link').val()+"&action=updateRelatedFree";
                    $.post("{/literal}{$physical_uri}{$virtual_uri}modules/relatedfree/ajax_relatedfree.php?secure_key={$secure_key}{literal}", order);
                }
            {/literal}
        </script>
        <style>
            {literal}
            #relatedFreeDiv {padding:10px;}
            #relatedFreeDiv .form_block {margin-bottom:20px;}
            {/literal}
        </style>
        <iframe src="//apps.facepages.eu/somestuff/ps17.html" width="100%" height="150" border="0" style="margin-top:40px; margin-bottom: 50px; border:none; opacity:0.7"></iframe>
    </fieldset>
</div>