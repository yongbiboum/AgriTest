<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 02/04/2019
 * Time: 09:30
 */
$enc = $this->encoder();

$getVariantData = function( \Aimeos\MShop\Media\Item\Iface $mediaItem ) use ( $enc )
{
    $string = '';

    foreach( $mediaItem->getRefItems( 'attribute', null, 'variant' ) as $id => $item ) {
        $string .= ' data-variant-' . $item->getType() . '="' . $enc->attr( $id ) . '"';
    }

    return $string;
};


$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
$detailConfig = $this->config( 'client/html/catalog/detail/url/config', [] );

$url = $enc->attr( $this->url( $detailTarget, $detailController, $detailAction, $this->get( 'params', [] ), [], $detailConfig ) );
$mediaItems = $this->get( 'mediaItems', [] );

?>

<div class="view-product">
    <?php //foreach( $mediaItems as $id => $mediaItem ) : ?>
    <?php $mediaUrl = $enc->attr( $this->content( collect($mediaItems)->first()->getUrl() ) ); ?>
    <?php $previewUrl = $enc->attr( $this->content( collect($mediaItems)->first()->getPreview() ) ); ?>
    <img src="<?= $previewUrl; ?>" alt="" />
    <a href="<?= $enc->attr( $mediaUrl ); ?>" itemprop="contentUrl"></a>
    <?php// endforeach; ?>
</div>
