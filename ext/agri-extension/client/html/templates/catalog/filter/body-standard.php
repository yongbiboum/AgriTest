<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2018
 */

$enc = $this->encoder();
$phrase = $enc->attr( $this->param( 'f_search' ) );
$name = $enc->attr( $this->formparam( 'f_search' ) );
$hint = $this->translate( 'client', 'Please enter at least three characters' );

/** client/html/catalog/suggest/url/target
 * Destination of the URL where the controller specified in the URL is known
 *
 * The destination can be a page ID like in a content management system or the
 * module of a software development framework. This "target" must contain or know
 * the controller that should be called by the generated URL.
 *
 * Note: Up to 2015-02, the setting was available as
 * client/html/catalog/listsimple/url/target
 *
 * @param string Destination of the URL
 * @since 2014.03
 * @category Developer
 * @see client/html/catalog/suggest/url/controller
 * @see client/html/catalog/suggest/url/action
 * @see client/html/catalog/suggest/url/config
 * @see client/html/catalog/listsimple/url/target
 */
$suggestTarget = $this->config( 'client/html/catalog/suggest/url/target' );

/** client/html/catalog/suggest/url/controller
 * Name of the controller whose action should be called
 *
 * In Model-View-Controller (MVC) applications, the controller contains the methods
 * that create parts of the output displayed in the generated HTML page. Controller
 * names are usually alpha-numeric.
 *
 * Note: Up to 2015-02, the setting was available as
 * client/html/catalog/listsimple/url/controller
 *
 * @param string Name of the controller
 * @since 2014.03
 * @category Developer
 * @see client/html/catalog/suggest/url/target
 * @see client/html/catalog/suggest/url/action
 * @see client/html/catalog/suggest/url/config
 * @see client/html/catalog/listsimple/url/controller
 */
$suggestController = $this->config( 'client/html/catalog/suggest/url/controller', 'catalog' );

/** client/html/catalog/suggest/url/action
 * Name of the action that should create the output
 *
 * In Model-View-Controller (MVC) applications, actions are the methods of a
 * controller that create parts of the output displayed in the generated HTML page.
 * Action names are usually alpha-numeric.
 *
 * Note: Up to 2015-02, the setting was available as
 * client/html/catalog/listsimple/url/action
 *
 * @param string Name of the action
 * @since 2014.03
 * @category Developer
 * @see client/html/catalog/suggest/url/target
 * @see client/html/catalog/suggest/url/controller
 * @see client/html/catalog/suggest/url/config
 * @see client/html/catalog/listsimple/url/action
 */
$suggestAction = $this->config( 'client/html/catalog/suggest/url/action', 'suggest' );

/** client/html/catalog/suggest/url/config
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
 * Note: Up to 2015-02, the setting was available as
 * client/html/catalog/listsimple/url/config
 *
 * @param string Associative list of configuration options
 * @since 2014.03
 * @category Developer
 * @see client/html/catalog/suggest/url/target
 * @see client/html/catalog/suggest/url/controller
 * @see client/html/catalog/suggest/url/action
 * @see client/html/url/config
 * @see client/html/catalog/listsimple/url/config
 */
$suggestConfig = $this->config( 'client/html/catalog/suggest/url/config', [] );

$suggestUrl = $enc->attr( $this->url( $suggestTarget, $suggestController, $suggestAction, [], [], $suggestConfig ) );

$listTarget = $this->config( 'client/html/catalog/lists/url/target' );
$listController = $this->config( 'client/html/catalog/lists/url/controller', 'catalog' );
$listAction = $this->config( 'client/html/catalog/lists/url/action', 'list' );
$listConfig = $this->config( 'client/html/catalog/lists/url/config', [] );
$listParams = [];
$params = $this->param();

/*
 * Use this array instead if you want to keep the selected category and the
 * entered search string as well:
 *
 * ['f_catid', 'f_search', 'f_sort']
 *
 * Downside: It will be impossible for customers to deselect the category!
 */
foreach( ['f_sort'] as $name ) {
    if( isset( $params[$name] ) ) { $listParams[$name] = $params[$name]; }
}

?>
<div class="col-sm-3">
    <form class="form-inline mr-auto mb-4" method="GET"
          action="<?= $enc->attr( $this->url( $listTarget, $listController, $listAction, $listParams, [], $listConfig ) ); ?>">
        <?= $this->csrf()->formfield(); ?>
        <input class="form-control mr-sm-2" type="text"
               name="<?= $name; ?>" value="<?= $phrase; ?>"
               data-url="<?= $suggestUrl; ?>" data-hint="<?= $hint; ?>"
               placeholder="<?= $enc->html( $this->translate( 'client', 'Search' ), $enc::TRUST ); ?> produit" aria-label="Search">
        <button  class="btn btn-outline-success btn-rounded btn-sm my-0" type="submit"><?= $enc->html( $this->translate( 'client', 'Go' ), $enc::TRUST ); ?></button>
		<!--<div class="search_box pull-right">
            <input type="text" placeholder="Search"/>
        </div>!-->
    </form>
</div>

