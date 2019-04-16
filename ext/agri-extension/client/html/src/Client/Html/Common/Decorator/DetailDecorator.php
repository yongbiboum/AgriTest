<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 15/04/2019
 * Time: 16:33
 */

namespace Aimeos\Client\Html\Common\Decorator;


class DetailDecorator extends \Aimeos\Client\Html\Common\Decorator\Base implements Iface
{


    public function addData( \Aimeos\MW\View\Iface $view, array &$tags = [], &$expire = null )
    {
        $view = parent::addData( $view, $tags, $expire );
        $context = $this->getContext();
        $config = $context->getConfig();
        $prodid = $view->param( 'd_prodid' );

        if( $prodid == '' )
        {
            /** client/html/catalog/detail/prodid-default
             * The default product ID used if none is given as parameter
             *
             * To display a product detail view or a part of it for a specific
             * product, you can configure its ID using this setting. This is
             * most useful in a CMS where the product ID can be configured
             * separately for each content node.
             *
             * @param string Product ID
             * @since 2016.01
             * @category User
             * @category Developer
             * @see client/html/catalog/lists/catid-default
             */
            $prodid = $config->get( 'client/html/catalog/detail/prodid-default', '' );
        }


        $domains = array( 'media', 'price', 'text', 'attribute', 'product', 'product/property' );

        /** client/html/catalog/domains
         * A list of domain names whose items should be available in the catalog view templates
         *
         * @see client/html/catalog/detail/domains
         */
        $domains = $config->get( 'client/html/catalog/domains', $domains );

        /** client/html/catalog/detail/domains
         * A list of domain names whose items should be available in the product detail view template
         *
         * The templates rendering product details usually add the images,
         * prices, texts, attributes, products, etc. associated to the product
         * item. If you want to display additional or less content, you can
         * configure your own list of domains (attribute, media, price, product,
         * text, etc. are domains) whose items are fetched from the storage.
         * Please keep in mind that the more domains you add to the configuration,
         * the more time is required for fetching the content!
         *
         * Since version 2014.05 this configuration option overwrites the
         * "client/html/catalog/domains" option that allows to configure the
         * domain names of the items fetched for all catalog related data.
         *
         * @param array List of domain names
         * @since 2014.03
         * @category Developer
         * @see client/html/catalog/domains
         * @see client/html/catalog/lists/domains
         */
        $domains = $config->get( 'client/html/catalog/detail/domains', $domains );


        $controller = \Aimeos\Controller\Frontend\Factory::createController( $context, 'catalog' );
        $prodCntl = \Aimeos\Controller\Frontend\Factory::createController( $context, 'product' );

        $productItem = $prodCntl->getItem( $prodid, $domains );
        $this->addMetaItems( $productItem, $expire, $tags );

        $products = $productItem->getRefItems( 'product' );
        $this->addMetaItems( $products, $expire, $tags );


        /** client/html/catalog/detail/stock/enable
         * Enables or disables displaying product stock levels in product detail view
         *
         * This configuration option allows shop owners to display product
         * stock levels for each product in the detail views or to disable
         * fetching product stock information.
         *
         * The stock information is fetched via AJAX and inserted via Javascript.
         * This allows to cache product items by leaving out such highly
         * dynamic content like stock levels which changes with each order.
         *
         * @param boolean Value of "1" to display stock levels, "0" to disable displaying them
         * @since 2014.03
         * @category User
         * @category Developer
         * @see client/html/catalog/lists/stock/enable
         * @see client/html/catalog/stock/url/target
         * @see client/html/catalog/stock/url/controller
         * @see client/html/catalog/stock/url/action
         * @see client/html/catalog/stock/url/config
         */




        $view->detailProductItems = $products;
        $view->detailProductItem = $productItem;
        $view->stocklevel = collect($this->getStockItems([$productItem->getCode()]))->first()->getStockLevel();
        $view->description = collect($productItem->getRefItems('text','long','default'))->first()->getContent();
        $view->detailParams = $this->getClientParams( $view->param() );
        return($view);

    }

    protected function getStockItems( array $productCodes )
    {
        $context = $this->getContext();

        /** client/html/catalog/stock/sort
         * Sortation keys if stock levels for different types exist
         *
         * Products can be shipped from several warehouses with a different
         * stock level for each one. The stock levels for each warehouse will
         * be shown in the product detail page. To get a consistent sortation
         * of this list, the configured keys will be used by the stock manager.
         *
         * The list consists of the sort key and the direction
         * (+: ascending, -: descending):
         *  array(
         *      'stock.productcode' => '+',
         *      'stock.stocklevel' => '-',
         *      'stock.type.code' => '+',
         *      'stock.dateback' => '+',
         *  )
         *
         * @param array List of key/value pairs for sorting
         * @since 2017.01
         * @category Developer
         * @see client/html/catalog/stock/level/low
         */
        $default = array( 'stock.productcode' => '+', 'stock.type.code' => '+' );
        $sortKeys = $context->getConfig()->get( 'client/html/catalog/stock/sort', $default );

        $siteConfig = $context->getLocale()->getSite()->getConfig();
        $cntl = \Aimeos\Controller\Frontend\Factory::createController( $context, 'stock' );

        $filter = $cntl->createFilter()->setSlice( 0, count( $productCodes ) );
        $filter = $cntl->addFilterCodes( $filter, $productCodes );

        if( isset( $siteConfig['stocktype'] ) ) {
            $filter = $cntl->addFilterTypes( $filter, [$siteConfig['stocktype']] );
        }

        $sortations = [];
        foreach( $sortKeys as $key => $dir ) {
            $sortations[] = $filter->sort( $dir, $key );
        }

        $filter->setSortations( $sortations );

        return $cntl->searchItems( $filter );
    }
}
