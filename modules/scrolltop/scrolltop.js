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

$(document).ready(function(){
 $('.mypresta_scrollup').click(function(event){
  event.preventDefault();
  $("html, body").animate({ scrollTop: 0 }, 600);
   return false;
 });
 $(window).scroll(function(){
  if ($(this).scrollTop() > 50) {
   $('.mypresta_scrollup').fadeIn();
  } else {
   $('.mypresta_scrollup').fadeOut();
  }
 });
});