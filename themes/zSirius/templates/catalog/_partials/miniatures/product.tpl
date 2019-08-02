{**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div class="col-xs-12 col-sm-6 col-md-3">
  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container">
      {block name='product_thumbnail'}
        <div class="portfolio-box">
          <img
            src = "{$product.cover.bySize.home_default.url}"
            alt = "{$product.cover.legend}"
            data-full-size-image-url = "{$product.cover.large.url}"
          >
          <div class="portfolio-box-caption">
            <div class="portfolio-box-caption-content">
              <a href="#" class="button button_quick-view quick-view" data-link-action="quickview">
                <i class="material-icons search">&#xE8B6;</i>
              </a>
            </div>
          </div>
        </div>
      {/block}

      <div class="product-description">
        {block name='product_name'}
          <h1 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h1>
        {/block}

        {block name='product_price_and_shipping'}
          {if $product.show_price}
            {if $product.has_discount}
              <div class="product-price-and-shipping">
                {hook h='displayProductPriceBlock' product=$product type="before_price"}
                  {hook h='displayProductPriceBlock' product=$product type="old_price"}
                  <span class="regular-price">{$product.regular_price}</span>
                  <br>
                  <span itemprop="price" class="price">{$product.price}</span>

                {hook h='displayProductPriceBlock' product=$product type='unit_price'}

                {hook h='displayProductPriceBlock' product=$product type='weight'}
              </div>
              {else}
                 <div class="product-price-and-shipping no-regular-price">
                  {hook h='displayProductPriceBlock' product=$product type="before_price"}
                    {hook h='displayProductPriceBlock' product=$product type="old_price"}
                    
                    <span itemprop="price" class="price">{$product.price}</span>

                  {hook h='displayProductPriceBlock' product=$product type='unit_price'}

                  {hook h='displayProductPriceBlock' product=$product type='weight'}
                </div>
            {/if}
          {/if}
        {/block}

        <div class="button-group">
          {include file='catalog/_partials/customize/button-cart.tpl' product=$product}

          <!-- <a href="{$product.url}" class="button button_more" >
            More
          </a> -->

        </div>
        
      </div>
      {block name='product_flags'}
        <a class="product-flags">
          {foreach from=$product.flags item=flag}
            <span class="{$flag.type}">
              {$flag.label}
              <b></b>
            </span>
          {/foreach}
        </a>
      {/block}

    </div>
  </article>
</div>