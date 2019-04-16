<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 27/03/2019
 * Time: 15:01
 */

$enc = $this->encoder();

$basketTarget = $this->config( 'client/html/basket/standard/url/target' );
$basketController = $this->config( 'client/html/basket/standard/url/controller', 'basket' );
$basketAction = $this->config( 'client/html/basket/standard/url/action', 'index' );
$basketConfig = $this->config( 'client/html/basket/standard/url/config', [] );

$checkoutTarget = $this->config( 'client/html/checkout/standard/url/target' );
$checkoutController = $this->config( 'client/html/checkout/standard/url/controller', 'checkout' );
$checkoutAction = $this->config( 'client/html/checkout/standard/url/action', 'index' );
$checkoutConfig = $this->config( 'client/html/checkout/standard/url/config', [] );

$optTarget = $this->config( 'client/jsonapi/url/target' );
$optCntl = $this->config( 'client/jsonapi/url/controller', 'jsonapi' );
$optAction = $this->config( 'client/jsonapi/url/action', 'options' );
$optConfig = $this->config( 'client/jsonapi/url/config', [] );

?>
<section id="cart_items" data-jsonurl="<?= $enc->attr( $this->url( $optTarget, $optCntl, $optAction, [], [], $optConfig ) ); ?>">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="/list">Marché</a></li>
				  <li class="active">Ma Cargaison</li>
				</ol>
			</div>

            <?php if( isset( $this->standardBasket ) ) : ?>
            <form method="POST" action="<?= $enc->attr( $this->url( $basketTarget, $basketController, $basketAction, [], [], $basketConfig ) ); ?>">
                <div class="table-responsive cart_info">
                <?= $this->csrf()->formfield(); ?>
                <?= $this->partial(
                /** client/html/basket/standard/summary/detail
                 * Location of the detail partial template for the basket standard component
                 *
                 * To configure an alternative template for the detail partial, you
                 * have to configure its path relative to the template directory
                 * (usually client/html/templates/). It's then used to display the
                 * product detail block in the basket standard component.
                 *
                 * @param string Relative path to the detail partial
                 * @since 2017.01
                 * @category Developer
                 */
                    $this->config( 'client/html/basket/standard/summary/detail', 'common/summary/detail-standard.php' ),
                    array(
                        'summaryEnableModify' => true,
                        'summaryBasket' => $this->standardBasket,
                        'summaryTaxRates' => $this->get( 'standardTaxRates', [] ),
                        'summaryErrorCodes' => $this->get( 'standardErrorCodes', [] ),
                    )
                ); ?>
                </div>
            </form>
            <?php endif; ?>

        </div>
	</section>
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Total Cargaison <span>$59</span> </li>
                        <li>Taxes <span></span></li>
                        <li>Prix de Livraison  <span></span></li>
                        <li>Total <span>$61</span></li>
                    </ul>
                    <!--<a class="btn btn-default update" href="">Update</a>!-->
                    <?php if( $this->get( 'standardCheckout', false ) === true ) : ?>
                    <a class="btn btn-default check_out" href="<?= $enc->attr( $this->url( $checkoutTarget, $checkoutController, $checkoutAction, [], [], $checkoutConfig ) ); ?>">
                        Commander</a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php else : ?>
<?php endif; ?>
