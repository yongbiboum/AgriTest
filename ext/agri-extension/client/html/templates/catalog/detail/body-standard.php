<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 01/04/2019
 * Time: 10:31
 */
$getProductList = function( array $posItems, array $items )
{
    $list = [];

    foreach( $posItems as $id => $posItem )
    {
        if( isset( $items[$id] ) ) {
            $list[$id] = $items[$id];
        }
    }

    return $list;
};


$enc = $this->encoder();

$optTarget = $this->config( 'client/jsonapi/url/target' );
$optCntl = $this->config( 'client/jsonapi/url/controller', 'jsonapi' );
$optAction = $this->config( 'client/jsonapi/url/action', 'options' );
$optConfig = $this->config( 'client/jsonapi/url/config', [] );

$basketTarget = $this->config( 'client/html/basket/standard/url/target' );
$basketController = $this->config( 'client/html/basket/standard/url/controller', 'basket' );
$basketAction = $this->config( 'client/html/basket/standard/url/action', 'index' );
$basketConfig = $this->config( 'client/html/basket/standard/url/config', [] );
$basketSite = $this->config( 'client/html/basket/standard/url/site' );

$basketParams = ( $basketSite ? ['site' => $basketSite] : [] );


/** client/html/basket/require-stock
 * Customers can order products only if there are enough products in stock
 *
 * Checks that the requested product quantity is in stock before
 * the customer can add them to his basket and order them. If there
 * are not enough products available, the customer will get a notice.
 *
 * @param boolean True if products must be in stock, false if products can be sold without stock
 * @since 2014.03
 * @category Developer
 * @category User
 */
$reqstock = (int) $this->config( 'client/html/basket/require-stock', true );

$prodItems = $this->get( 'detailProductItems', [] );

$propMap = $subPropDeps = $propItems = [];
$attrMap = $subAttrDeps = $mediaItems = [];

$reqstock = (int) $this->config( 'client/html/basket/require-stock', true );

$prodItems = $this->get( 'detailProductItems', [] );

$propMap = $subPropDeps = $propItems = [];
$attrMap = $subAttrDeps = $mediaItems = [];

if( isset( $this->detailProductItem ) )
{
    $propItems = $this->detailProductItem->getPropertyItems();
    $posItems = $this->detailProductItem->getRefItems( 'product', null, 'default' );

    if( in_array( $this->detailProductItem->getType(), ['bundle', 'select'] ) )
    {
        foreach( $getProductList( $posItems, $prodItems ) as $subProdId => $subProduct )
        {
            $subItems = $subProduct->getRefItems( 'attribute', null, 'default' );
            $subItems += $subProduct->getRefItems( 'attribute', null, 'variant' ); // show product variant attributes as well
            $mediaItems = array_merge( $mediaItems, $subProduct->getRefItems( 'media', 'default', 'default' ) );

            foreach( $subItems as $attrId => $attrItem )
            {
                $attrMap[ $attrItem->getType() ][ $attrId ] = $attrItem;
                $subAttrDeps[ $attrId ][] = $subProdId;
            }

            $propItems = array_merge( $propItems, $subProduct->getPropertyItems() );
        }
    }

    foreach( $propItems as $propId => $propItem )
    {
        $propMap[ $propItem->getType() ][ $propId ] = $propItem;
        $subPropDeps[ $propId ][] = $propItem->getParentId();
    }
}

?>


<div class="container">
    <div class="row">
    <?php
    //$mediaItems = $this->myparam ;

    ?>
        <?php
        $conf = $this->detailProductItem->getConfig();

        $disabled = '';
        $curdate = date( 'Y-m-d H:i:00' );

        if( ( $startDate = $this->detailProductItem->getDateStart() ) !== null && $startDate > $curdate
            || ( $endDate = $this->detailProductItem->getDateEnd() ) !== null && $endDate < $curdate
        ) {
            $disabled = 'disabled';
        }
        ?>
<div class="col-sm-9 padding-right">
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <?= $this->partial(
            /** client/html/catalog/detail/partials/image
             * Relative path to the detail image partial template file
             *
             * Partials are templates which are reused in other templates and generate
             * reoccuring blocks filled with data from the assigned values. The image
             * partial creates an HTML block for the catalog detail images.
             *
             * @param string Relative path to the template file
             * @since 2017.01
             * @category Developer
             */
                $this->config( 'client/html/catalog/detail/partials/image', 'catalog/detail/image-partial-standard.php' ),
                array(
                    'productItem' => $this->detailProductItem,
                    'params' => $this->get( 'detailParams', [] ),
                    'mediaItems' => array_merge( $this->detailProductItem->getRefItems( 'media', 'default', 'default' ), $mediaItems )
                )
            ); ?>
        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="/packages/aimeos/shop/themes/elegance/media/product-details/new.jpg" class="newarrival" alt="" />

                <h1><?= $enc->html( $this->detailProductItem->getName(), $enc::TRUST ); ?></h1>
                <p ><?= $enc->html( $this->translate( 'client', 'Article no.:' ), $enc::TRUST ); ?>
                <?= $enc->html( $this->detailProductItem->getCode() ); ?></p>
                <p class="">Producteur : </p><img src="/packages/aimeos/shop/themes/elegance/media/product-details/rating.png" alt="" />

                <?php if( isset( $this->detailProductItem ) ) :
                $unité= collect($this->detailProductItem->getRefItems('text','unité de masse','default'))->first()->getLabel();
                ?>
            <?php $prices=$this->detailProductItem->getRefItems( 'price', null, 'default' ); $price = collect($prices)->first()->getValue();
            $currency = collect($prices)->first()->getCurrencyId();
            $text = $this->description ;
            ?>
            <hr width="100%">
                <span>
                    <h5>
                        <?= $text ;?>
                        <a href="" class=""> voir plus de détail</a>
                    </h5>
                    <hr width="100%">
									<span>Prix Unitaire : <?=$this->number($price,0) ?> <?=$currency ?> </span>
                    <?php endif; ?>
                    <form method="POST" action="<?= $enc->attr( $this->url( $basketTarget, $basketController, $basketAction, $basketParams, [], $basketConfig ) ); ?>">
                    <?= $this->csrf()->formfield(); ?>
                        <p class=""><b>Stock actuel : <?= $this->stocklevel; ?> <?= $unité ;?>  </b><br>
                        <b class="">Début : <?= $startDate; ?> </b><br>
                        <b class="">Fin : <?= $endDate?$endDate:'non défini'; ?> </b>
                        </p>
                        <label>Quantité : </label>
                                    <input type="number" class="" <?= $disabled ?>
                                        name="<?= $enc->attr( $this->formparam( array( 'b_prod', 0, 'quantity' ) ) ); ?>"
                                           min="1" max="2147483647" maxlength="10" step="1" required="required" value="1"
                                      />
                        <?= $unité ;?>
								</span>


                <?php if( $basketSite ) : ?>
                        <input type="hidden" name="<?= $this->formparam( 'site' ) ?>" value="<?= $enc->attr( $basketSite ) ?>" />
                    <?php endif ?>
                    <?php foreach( $this->detailProductItem->getRefItems( 'product', null, 'default' ) as $articleId => $articleItem ) : ?>
                        <?= $enc->attr( $articleItem->getCode() ); ?>
                    <?php endforeach; ?>
                </p>
                <input type="hidden" value="add"
                       name="<?= $enc->attr( $this->formparam( 'b_action' ) ); ?>"
                />
                <input type="hidden"
                       name="<?= $enc->attr( $this->formparam( array( 'b_prod', 0, 'prodid' ) ) ); ?>"
                       value="<?= $enc->attr( $this->detailProductItem->getId() ); ?>"
                />
                <hr width="100%">
                <button type="submit" class="btn btn-fefault cart">
                    <i class="fa fa-truck"></i>
                    Achat
                </button>
                </form>
                <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->

    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li><a href="#details" data-toggle="tab">Details</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
                <li><a href="#tag" data-toggle="tab">Tag</a></li>
                <li class="active"><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="details" >
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery1.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery2.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery3.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery4.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="companyprofile" >
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery1.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery3.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery2.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery4.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tag" >
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery1.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery2.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery3.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="images/home/gallery4.jpg" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade active in" id="reviews" >
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>

                    <form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
                        <textarea name="" ></textarea>
                        <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div><!--/category-tab-->

    <div class="recommended_items"><!--recommended_items-->
        <h2 class="title text-center">produits recommandés</h2>
        <?php if( ( $posItems = $this->detailProductItem->getRefItems( 'product', null, 'suggestion' ) ) !== []
            && ( $products = $getProductList( $posItems, $prodItems ) ) !== [] ) : ?>

            <section class="catalog-detail-suggest">



            </section>

        <?php endif; ?>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="images/home/recommend2.jpg" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="images/home/recommend3.jpg" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="images/home/recommend1.jpg" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="images/home/recommend2.jpg" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="images/home/recommend3.jpg" alt="" />
                                    <h2>$56</h2>
                                    <p>Easy Polo Black Edition</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div><!--/recommended_items-->

</div>
    </div>
</div>

