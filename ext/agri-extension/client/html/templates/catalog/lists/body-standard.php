
<?php
//dd(config( 'client/html/catalog/lists/url/controller', 'catalog' ));
$enc = $this->encoder();
$params = $this->get( 'listParams', [] );
$catPath = $this->get( 'listCatPath', [] );

$target = $this->config( 'client/html/catalog/lists/url/target' );
$cntl = $this->config( 'client/html/catalog/lists/url/controller', 'catalog' );
$action = $this->config( 'client/html/catalog/lists/url/action', 'list' );
$config = $this->config( 'client/html/catalog/lists/url/config', [] );

$optTarget = $this->config( 'client/jsonapi/url/target' );
$optCntl = $this->config( 'client/jsonapi/url/controller', 'jsonapi' );
$optAction = $this->config( 'client/jsonapi/url/action', 'options' );
$optConfig = $this->config( 'client/jsonapi/url/config', [] );



$classes = '';
/*foreach( (array) $this->get( 'listCatPath', [] ) as $cat )
{
   $catConfig = $cat->getConfig();
    if( isset( $catConfig['css-class'] ) ) {
        $classes .= ' ' . $catConfig['css-class'];
    }
}*/


/** client/html/catalog/lists/head/text-types
 * The list of text types that should be rendered in the catalog list head section
 *
 * The head section of the catalog list view at least consists of the category
 * name. By default, all short and long descriptions of the category are rendered
 * as well.
 *
 * You can add more text types or remove ones that should be displayed by
 * modifying these list of text types, e.g. if you've added a new text type
 * and texts of that type to some or all categories.
 *
 * @param array List of text type names
 * @since 2014.03
 * @category User
 * @category Developer
 */
$textTypes = $this->config( 'client/html/catalog/lists/head/text-types', array( 'short', 'long' ) );


$quoteItems = [];
if( $catPath !== [] && ( $catItem = end( $catPath ) ) !== false ) {
    $quoteItems = $catItem->getRefItems( 'text', 'quote', 'default' );
}


$pagination = '';
if( $this->get( 'listProductTotal', 0 ) > 1 )
{
    /** client/html/catalog/lists/partials/pagination
     * Relative path to the pagination partial template file for catalog lists
     *
     * Partials are templates which are reused in other templates and generate
     * reoccuring blocks filled with data from the assigned values. The pagination
     * partial creates an HTML block containing a page browser and sorting links
     * if necessary.
     *
     * @param string Relative path to the template file
     * @since 2017.01
     * @category Developer
     */
   $pagination = $this->partial(
        $this->config( 'client/html/catalog/lists/partials/pagination', 'catalog/lists/pagination-standard.php' ),
        array(
            'params' => $params,
            'size' => $this->get( 'listPageSize', 48 ),
            'total' => $this->get( 'listProductTotal', 0 ),
            'current' => $this->get( 'listPageCurr', 0 ),
            'prev' => $this->get( 'listPagePrev', 0 ),
            'next' => $this->get( 'listPageNext', 0 ),
            'last' => $this->get( 'listPageLast', 0 ),
        )
    );
}

//$enc = $this->encoder();



?>
        <?= $this->block()->get( 'catalog/lists/items' ); ?>

