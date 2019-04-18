<?php

/**
* @author: Ayoub El Hobbi
*/

namespace Stoune\Providers;


use IO\Extensions\Functions\Partial;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\ComponentContainer;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use IO\Services\ItemSearch\Helper\ResultFieldTemplate;

/**
 * Class StouneServiceProvider
 * @package Stoune\Providers
 */
class StouneServiceProvider extends ServiceProvider
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
           $container->addScriptTemplate('Stoune::ThemeScript');
       }, self::PRIORITY);

          /* Footer überschreiben  */
      $dispatcher->listen('IO.init.templates', function(Partial $partial)
			 {
					$partial->set('footer', 'Stoune::ThemeFooter');
          $partial->set( 'page-design', 'Stoune::PageDesign.PageDesign' );
			 }, 0);

          /* SingleItem überschreiben */
       $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
			 {
					 if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
					 {
							 $container->setNewComponentTemplate('Stoune::Item.Components.SingleItem');
					 }
			 }, self::PRIORITY);

          /* ResultFields SingleItemWrapper überschreiben  */
       $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_SINGLE_ITEM => 'Stoune::ResultFields.SingleItemWrapper'
      ]);
     }, 0);

        /* ListItem JSON überschreiben */
    $dispatcher->listen( 'IO.ResultFields.*', function(ResultFieldTemplate $templateContainer) {
      $templateContainer->setTemplates([
          ResultFieldTemplate::TEMPLATE_LIST_ITEM => 'Stoune::ResultFields.ListItem'
      ]);
    }, 0);

        /* Überschreiben der ItemImageCarousel */
    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
    if( $container->getOriginComponentTemplate() == 'Ceres::Item.Components.ItemImageCarousel')
    {
       $container->setNewComponentTemplate('Stoune::Item.ItemImageCarousel');
    }
     }, self::PRIORITY);

     /* Überschreiben der ContactForm.twig */
     $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::Customer.Components.Contact.ContactForm')
     {
        $container->setNewComponentTemplate('Stoune::Customer.Components.Contact.ContactForm');
     }
      }, self::PRIORITY);

     /* Überschreiben der ShippingProfileSelect */
   $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
   if( $container->getOriginComponentTemplate() == 'Ceres::Checkout.Components.ShippingProfileSelect')
   {
      $container->setNewComponentTemplate('Stoune::Checkout.Components.ShippingProfileSelect');
   }
    }, self::PRIORITY);

    /* Überschreiben der Summen im Checkout - Checkout Totals einmal anpassen und überall anfragen! */
    $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::Basket.Components.BasketTotals')
     {
        $container->setNewComponentTemplate('Stoune::Basket.Components.BasketTotals');
     }
      }, self::PRIORITY);

      /* KategorieAnsicht bei Auswahl der Navigation überschreiben  */
     $dispatcher->listen('IO.Component.Import', function(ComponentContainer $container){
     if( $container->getOriginComponentTemplate() == 'Ceres::ItemList.Components.CategoryItem')
     {
        $container->setNewComponentTemplate('Stoune::ItemList.Components.CategoryItem');
     }
      }, self::PRIORITY);

      /* Überschreiben der CategoryItem  */
    $dispatcher->listen('IO.tpl.category.item', function(TemplateContainer $container){

       $container->setTemplate('Stoune::Category.Item.CategoryItem');

     }, self::PRIORITY);

     /* Überschreiben der Bestätigungsseite */
     $dispatcher->listen('IO.tpl.confirmation', function (TemplateContainer $container)
     {
        $container->setTemplate('Stoune::Checkout.OrderConfirmation');

     }, self::PRIORITY);



    }
}
