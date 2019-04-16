<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 02/04/2019
 * Time: 15:35
 */


$totalQuantity = 0;
$enc = $this->encoder();

$basketTarget = $this->config( 'client/html/basket/standard/url/target' );
$basketController = $this->config( 'client/html/basket/standard/url/controller', 'basket' );
$basketAction = $this->config( 'client/html/basket/standard/url/action', 'index' );
$basketConfig = $this->config( 'client/html/basket/standard/url/config', [] );

$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
$detailConfig = $this->config( 'client/html/catalog/detail/url/config', array( 'absoluteUri' => 1 ) );


/** client/html/account/download/url/target
 * Destination of the URL where the controller specified in the URL is known
 *
 * The destination can be a page ID like in a content management system or the
 * module of a software development framework. This "target" must contain or know
 * the controller that should be called by the generated URL.
 *
 * @param string Destination of the URL
 * @since 2016.02
 * @category Developer
 * @see client/html/account/download/url/controller
 * @see client/html/account/download/url/action
 * @see client/html/account/download/url/config
 */
$dlTarget = $this->config( 'client/html/account/download/url/target' );

/** client/html/account/download/url/controller
 * Name of the controller whose action should be called
 *
 * In Model-View-Controller (MVC) applications, the controller contains the methods
 * that create parts of the output displayed in the generated HTML page. Controller
 * names are usually alpha-numeric.
 *
 * @param string Name of the controller
 * @since 2016.02
 * @category Developer
 * @see client/html/account/download/url/target
 * @see client/html/account/download/url/action
 * @see client/html/account/download/url/config
 */
$dlController = $this->config( 'client/html/account/download/url/controller', 'account' );

/** client/html/account/download/url/action
 * Name of the action that should create the output
 *
 * In Model-View-Controller (MVC) applications, actions are the methods of a
 * controller that create parts of the output displayed in the generated HTML page.
 * Action names are usually alpha-numeric.
 *
 * @param string Name of the action
 * @since 2016.02
 * @category Developer
 * @see client/html/account/download/url/target
 * @see client/html/account/download/url/controller
 * @see client/html/account/download/url/config
 */
$dlAction = $this->config( 'client/html/account/download/url/action', 'download' );

/** client/html/account/download/url/config
 * Associative list of configuration options used for generating the URL
 *
 * You can specify additional options as key/value pairs used when generating
 * the URLs, like
 *
 *  client/html/<clientname>/url/config = array( 'absoluteUri' => true )
 *
 * The available key/value pairs depend on the application that embeds the e-commerce
 * framework. This is because the infrastructure of the application is used for
 * generating the URLs. The full list of available config options is referenced
 * in the "see also" section of this page.
 *
 * @param string Associative list of configuration options
 * @since 2016.02
 * @category Developer
 * @see client/html/account/download/url/target
 * @see client/html/account/download/url/controller
 * @see client/html/account/download/url/action
 */
$dlConfig = $this->config( 'client/html/account/download/url/config', array( 'absoluteUri' => 1 ) );

/** client/html/common/summary/detail/product/attribute/types
 * List of attribute type codes that should be displayed in the basket along with their product
 *
 * The products in the basket can store attributes that exactly define an ordered
 * product or which are important for the back office. By default, the product
 * variant attributes are always displayed and the configurable product attributes
 * are displayed separately.
 *
 * Additional attributes for each ordered product can be added by basket plugins.
 * Depending on the attribute types and if they should be shown to the customers,
 * you need to extend the list of displayed attribute types ab adding their codes
 * to the configurable list.
 *
 * @param array List of attribute type codes
 * @category Developer
 * @since 2014.09
 */
$attrTypes = $this->config( 'client/html/common/summary/detail/product/attribute/types', array( 'variant' ) );

$priceTaxvalue = '0.00';

if( isset( $this->summaryBasket ) )
{
    $price = $this->summaryBasket->getPrice();
    $priceValue = $price->getValue();
    $priceService = $price->getCosts();
    $priceRebate = $price->getRebate();
    $priceTaxflag = $price->getTaxFlag();
    $priceCurrency = $this->translate( 'currency', $price->getCurrencyId() );
}
else
{
    $priceValue = '0.00';
    $priceRebate = '0.00';
    $priceService = '0.00';
    $priceTaxflag = true;
    $priceCurrency = '';
}


$deliveryName = '';
$deliveryPriceValue = '0.00';
$deliveryPriceService = '0.00';

foreach( $this->summaryBasket->getService( 'delivery' ) as $service )
{
    $deliveryName = $service->getName();
    $deliveryPriceItem = $service->getPrice();
    $deliveryPriceService += $deliveryPriceItem->getCosts();
    $deliveryPriceValue += $deliveryPriceItem->getValue();
}

$paymentName = '';
$paymentPriceValue = '0.00';
$paymentPriceService = '0.00';

foreach( $this->summaryBasket->getService( 'payment' ) as $service )
{
    $paymentName = $service->getName();
    $paymentPriceItem = $service->getPrice();
    $paymentPriceService += $paymentPriceItem->getCosts();
    $paymentPriceValue += $paymentPriceItem->getValue();
}


/// Price format with price value (%1$s) and currency (%2$s)
$priceFormat = $this->translate( 'client', '%1$s %2$s' );

$unhide = $this->get( 'summaryShowDownloadAttributes', false );
$modify = $this->get( 'summaryEnableModify', false );
$errors = $this->get( 'summaryErrorCodes', [] );

?>

    <table class="table table-condensed">
        <thead>
        <tr class="cart_menu">
            <td class="image">Produit</td>
            <td class="description"></td>
            <td class="price">Prix unitaire</td>
            <td class="quantity">Quantité</td>
            <td class="total">Total</td>
            <td></td>
        </tr>
        </thead>

        <tbody>
        <?php foreach( $this->summaryBasket->getProducts() as $position => $product ) : $totalQuantity += $product->getQuantity(); ?>

        <tr>
            <td class="cart_product">
                <?php
                $name = $product->getName();
                if( ( $pos = strpos( $name, "\n" ) ) !== false ) { $name = substr( $name, 0, $pos ); }
                $params = array_merge( $this->param(), ['d_prodid' => $product->getProductId(), 'd_name' => $name] );
                ?>
                <a href="<?= $enc->attr( $this->url( ( $product->getTarget() ?: $detailTarget ), $detailController, $detailAction, $params, [], $detailConfig ) ); ?>">
                <?php if( ( $url = $product->getMediaUrl() ) != '' ) : // fixed width for e-mail clients ?>
                    <img class="detail" src="<?= $enc->attr( $this->content( $url ) ); ?>" width="100" />
                <?php endif; ?>
                </a>
            </td>
            <td class="cart_description">
                <?php
                $name = $product->getName();
                if( ( $pos = strpos( $name, "\n" ) ) !== false ) { $name = substr( $name, 0, $pos ); }
                $params = array_merge( $this->param(), ['d_prodid' => $product->getProductId(), 'd_name' => $name] );
                ?>
                <h4>
                    <a href="<?= $enc->attr( $this->url( ( $product->getTarget() ?: $detailTarget ), $detailController, $detailAction, $params, [], $detailConfig ) ); ?>">
                        <?= $enc->html( $product->getName(), $enc::TRUST ); ?>
                    </a>
                </h4>
                <p>
                    <span class="name"><?= $enc->html( $this->translate( 'client', 'Article no.:' ), $enc::TRUST ); ?></span>
                    <span class="value"><?= $product->getProductCode(); ?></span>
                </p>
            </td>
            <td class="cart_price">
                <p><?= $enc->html( sprintf( $priceFormat, $this->number( $product->getPrice()->getValue() ), $priceCurrency ) ); ?></p>
            </td>
            <td class="cart_quantity">
                <div class="cart_quantity_button">
                    <?php if( $modify && ( $product->getFlags() & \Aimeos\MShop\Order\Item\Base\Product\Base::FLAG_IMMUTABLE ) == 0 ) : ?>

                        <?php if( $product->getQuantity() > 1 ) : ?>
                            <?php $basketParams = array( 'b_action' => 'edit', 'b_position' => $position, 'b_quantity' => $product->getQuantity() - 1 ); ?>
                            <a class="cart_quantity_down" href="<?= $enc->attr( $this->url( $basketTarget, $basketController, $basketAction, $basketParams, [], $basketConfig ) ); ?>">−</a>
                        <?php else : ?>
                            &nbsp;
                        <?php endif; ?>
                    <input class="cart_quantity_input" type="text" name="<?= $enc->attr( $this->formparam( array( 'b_prod', $position, 'quantity' ) ) ); ?>"
                           value="<?= $enc->attr( $product->getQuantity() ); ?>" maxlength="10" required="required" autocomplete="off" size="2"
                    />
                    <input type="hidden" type="text"
                           name="<?= $enc->attr( $this->formparam( array( 'b_prod', $position, 'position' ) ) ); ?>"
                           value="<?= $enc->attr( $position ); ?>"
                    />
                    <?php $basketParams = array( 'b_action' => 'edit', 'b_position' => $position, 'b_quantity' => $product->getQuantity() + 1 ); ?>
                    <a class="cart_quantity_up" href="<?= $enc->attr( $this->url( $basketTarget, $basketController, $basketAction, $basketParams, [], $basketConfig ) ); ?>">+</a>

                    <?php else : ?>
                        <?= $enc->html( $product->getQuantity() ); ?>
                    <?php endif; ?>

                </div>
            </td>
            <td class="cart_total">
                <p class="cart_total_price"><?= $enc->html( sprintf( $priceFormat, $this->number( $product->getPrice()->getValue() * $product->getQuantity() ), $priceCurrency ) ); ?></p>
            </td>

            <?php if( $modify ) : ?>
            <td class="cart_delete">
                <?php if( ( $product->getFlags() & \Aimeos\MShop\Order\Item\Base\Product\Base::FLAG_IMMUTABLE ) == 0 ) : ?>
                    <?php $basketParams = array( 'b_action' => 'delete', 'b_position' => $position ); ?>
                <a class="cart_quantity_delete" href="<?= $enc->attr( $this->url( $basketTarget, $basketController, $basketAction, $basketParams, [], $basketConfig ) ); ?> "><i class="fa fa-times"></i></a>
                <?php endif; ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

