<?php

/**
* @author: Ayoub El Hobbi
*/

namespace Theme\Providers;


use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ComponentContainer;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;

/**
 * Class LotuThemeServiceProvider
 * @package LotuTheme\Providers
 */
class ThemeServiceProvider extends ServiceProvider
{
    const PRIORITY = 0;

    public function register()
    {

    }

    public function boot(Dispatcher $dispatcher)
    {

          /* Skripte einbinden  */
      $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
       {
           $container->addScriptTemplate('Theme::ThemeScript');
       }, self::PRIORITY);

          /* Footer überschreiben  */
      $dispatcher->listen('IO.init.templates', function(Partial $partial)
			 {
					$partial->set('footer', 'Theme::ThemeFooter');
          $partial->set( 'page-design', 'Theme::PageDesign.PageDesign' );
			 }, 0);

          /* SingleItem überschreiben */
       $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
			 {
					 if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
					 {
							 $container->setNewComponentTemplate('Theme::Item.SingleItem');
					 }
			 }, self::PRIORITY);

          /* ResultFields SingleItemWrapper überschreiben  */
       $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_SINGLE_ITEM   => 'Theme::ResultFields.SingleItemWrapper'
      ]);
     }, 0);

          /* KategorieAnsicht bei Auswahl der Navigation überschreiben  */
     $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem')
     {
        $container->setNewComponentTemplate('Theme::ItemList.Components.CategoryItem');
     }
      }, self::PRIORITY);

        /* ListItem JSON überschreiben */
    $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_LIST_ITEM   => 'Theme::ResultFields.ListItem'
      ]);
    }, 0);

        /* Überschreiben der ItemImageCarousel */
    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
    if( $container->getOriginComponentTemplate() == 'Ceres::Ceres::Item.Components.ItemImageCarousel')
    {
       $container->setNewComponentTemplate('Theme::Item.ItemImageCarousel');
    }
     }, self::PRIORITY);

     /* Überschreiben der ShippingProfileSelect */
   $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
   if( $container->getOriginComponentTemplate() == 'Ceres::Checkout.Components.ShippingProfileSelect')
   {
      $container->setNewComponentTemplate('Theme::Checkout.Components.ShippingProfileSelect');
   }
    }, self::PRIORITY);


    /* Überschreiben der Summen im Checkout - Checkout Totals einmal anpassen und überall anfragen! */

    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::Basket.Components.BasketTotals')
     {
        $container->setNewComponentTemplate('Theme::Basket.Components.BasketTotals');
     }
      }, self::PRIORITY);

      /* Überschreiben der CategoryItem  */
    $dispatcher->listen('IO.tpl.category.item', function(TemplateContainer $container){

       $container->setTemplate('Theme::Category.Item.CategoryItem');

     }, self::PRIORITY);


    }
}
