<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 03/04/2019
 * Time: 16:23
 */
$catid = (isset($this->catid) ? $this->catid:0);
?>
<?php if(!$catid) :  ?>
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>Agri</span>-Business</h1>
                                <h2>Plateforme B2B </h2>
                                <h2>des professionnels du secteur primaire Africain</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Acheter un produit</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="packages/aimeos/shop/themes/elegance/media/home/slide/1.jpg" class="girl img-responsive" alt="" />

                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>Agri</span>-Business</h1>
                                <h2>L'économie numérique Au service du secteur primaire </h2>
                                <h2>  Africain </h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Acheter un produit</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="packages/aimeos/shop/themes/elegance/media/home/slide/3.jpg" class="girl img-responsive" alt="" />

                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>Agri</span>-Business</h1>
                                <h2>Plate-forme de promotion </h2>
                                <h2>Des produits d'agriculture et d'élevage africain </h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Acheter un produit</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="packages/aimeos/shop/themes/elegance/media/home/slide/2.jpg" class="girl img-responsive" alt="" />

                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<?php else :
    $baniere = $this->baniere;

    $url = (!is_null(collect($baniere)->first())) ? collect($baniere)->first()->getUrl():"";
?>
    <section id="advertisement">
        <div class="container">
            <img src="<?= $this->content($url); ?>" alt="" />
        </div>
    </section>
<?php endif; ?>
