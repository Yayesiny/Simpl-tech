{$col = 0}
<section class="featured-products clearfix">
  <h1 class="h1 products-section-title text-uppercase ">
    {l s='Popular Products' d='Shop.Theme.Catalog'}
  </h1>
  <div class="products">
    {foreach from=$products item="product"}

      {if $col == 0}
        <div class="row">
      {/if}

      {include file="catalog/_partials/miniatures/product.tpl" product=$product}

      {if $col == 3}
          </div>
          {$col = 0}
      {else}
          {$col = $col + 1}
      {/if}
       
    {/foreach}
    {if $col != 0}
      </div>
    {/if}
  </div>
  <a class="all-product-link pull-xs-left pull-md-right h4" href="{$allProductsLink}">
    {l s='All products' d='Shop.Theme.Catalog'}<i class="material-icons">&#xE315;</i>
  </a>
</section>