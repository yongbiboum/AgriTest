<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 27/03/2019
 * Time: 14:10
 *
 *
 */
$params = [];
?>

    <div class="left-sidebar">
        <h2>Categories</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <?php foreach ($this->tree as $cat2):?>
                <?php $cat2child=$cat2->getChildren();?>
                <?php foreach ($cat2child as $cat3):?>
                    <?php $cat3child=$cat3->getChildren();
                    //foreach ($cat4 as $cat5): */?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordian" href="#catalog-<?= $cat3->getId(); ?>">
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                </a>
                                <?php $params = ["code"=>$cat3->getCode()] ?>
                                <a  href="<?= route('agriext_categories', ["code"=>$cat3->getCode(),"id"=>$cat3->getId()]) ?>">
                                    <?php $cat3Label = $cat3->getLabel();?>
                                    <?= $cat3Label; ?>
                                </a></h4>
                        </div>

                        <div id="catalog-<?= $cat3->getId(); ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    <?php
                                    foreach ($cat3child as $cat4):
                                        $cat4Label = $cat4->getLabel() ; ?>
                                        <li><a href="<?= route('agriext_categories', ["code"=>$cat4->getCode(),"id"=>$cat4->getId()]) ?>"><?= $cat4Label; ?> </a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                    </div> <?php endforeach; ?>
            <?php endforeach; ?>

        </div>
        <div class="price-range"><!--price-range-->
            <h2>Price Range</h2>
            <div class="well text-center">
                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div><!--/price-range-->

        <div class="shipping text-center"><!--shipping-->
            <img src="{{ asset('packages/aimeos/shop/themes/elegance/media/home/agri4.jpg') }}" alt="" />
        </div><!--/shipping-->

    </div>

