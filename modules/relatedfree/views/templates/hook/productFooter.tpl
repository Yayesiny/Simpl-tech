{**
* PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
*
* @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
* @copyright 2010-9999 VEKIA
* @license   This program is not free software and you can't resell and redistribute it
*
* CONTACT WITH DEVELOPER http://mypresta.eu
* support@mypresta.eu
*}

<div id="featured-category-products-block-center" class="{$rf_maincss}">
    <h1 class="products-section-title text-uppercase ">
        {if $related_link==1}<a href="{$link->getCategoryLink($related_category, null, $id_lang)}">{/if}
            {l s='Related products' mod='relatedfree'}
        {if $related_link==1}</a>{/if}
    </h1>
    {if isset($products) && $products}
        <div class="{$rf_productscss}">
            {foreach from=$products item="product"}
                {include file=$rf_tpath product=$product}
            {/foreach}
        </div>
    {else}
        <ul id="categoryfeatured" class="categoryfeatured tab-pane">
            <li class="alert alert-info">{l s='No related products at this time.' mod='relatedfree'}</li>
        </ul>
    {/if}
</div>