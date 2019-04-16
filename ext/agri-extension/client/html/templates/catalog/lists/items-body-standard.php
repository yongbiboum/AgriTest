<?php

$enc = $this->encoder();
$position = $this->get( 'itemPosition' );
$productItems = $this->get( 'itemsProductItems', [] );

$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
$detailConfig = $this->config( 'client/html/catalog/detail/url/config', [] );

$basketTarget = $this->config( 'client/html/basket/standard/url/target' );
$basketController = $this->config( 'client/html/basket/standard/url/controller', 'basket' );
$basketAction = $this->config( 'client/html/basket/standard/url/action', 'index' );
$basketConfig = $this->config( 'client/html/basket/standard/url/config', [] );
$basketSite = $this->config( 'client/html/basket/standard/url/site' );

$basketParams = ( $basketSite ? ['site' => $basketSite] : [] );

?>
<?php $this->block()->start( 'catalog/lists/items' ); ?>
<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Produits</h2>
        <?php $productItems = $this->myparam;
        $text='';
        ?>
        <?php foreach($productItems as $id => $productItem) :
        $manager2 = \Aimeos\MShop\Factory::createManager( $this->context, 'product' );
        $productItemid = $manager2->getItem($productItem->getId(),['media','text','price']);?>
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <?php $mediaItem= collect($productItemid->getRefItems( 'media', 'default', 'default' ))->first()->getUrl();
                //$mediaUrl = $enc->attr( $this->content( $mediaItem->getPreview() ) );
                //$params = array( 'd_name' => $productItem->getName( 'url' ), 'd_prodid' => $id );

                if( $position !== null ) { $params['d_pos'] = $position++; }
                $prices = $productItemid->getRefItems( 'price', null, 'default' );
                $priceUrl=((collect($prices)->first())!==null)? collect($prices)->first()->getValue() : $text ;
                $textItem = collect($productItemid->getLabel())->first();
                $conf = $productItemid->getConfig(); $css = ( isset( $conf['css-class'] ) ? $conf['css-class'] : '' );
                $params = array( 'd_name' => $productItemid->getName( 'url' ), 'd_prodid' => $id , 'd_pos'=> 0 ,'locale' => app()->getLocale());
               // if( $position !== null ) { $params['d_pos'] = $position++; }

                $url = $this->url( ($productItemid->getTarget() ?: $detailTarget ), $detailController, $detailAction, $params, [], $detailConfig );
                ?>
                <div class="single-products">
                    <a href="<?= $url; ?>">
                        <div class="productinfo text-center">
                            <img src="<?= $this->content($mediaItem); ?>" alt="" />
                            <h2><?= $this->number($priceUrl,0);   ?></h2>
                            <p><?= $textItem; ?></p></a>
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ajout à la cargaison</a>
                </div>

                <div class="product-overlay">
                    <div class="overlay-content">
                        <a href="<?= $url; ?>">
                            <h2><?= $this->number($priceUrl,0); ?></h2>
                            <p><?= $textItem; ?></p>
                        </a>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Ajout à la cargaison</a>
                    </div>
                </div>
            </div>

            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                </ul>
            </div>
        </div>

    </div> <?php  endforeach; ?>
</div>

<?php $this->block()->stop(); ?>
<?= $this->block()->get( 'catalog/lists/items' ); ?>

