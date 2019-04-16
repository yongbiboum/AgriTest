<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categoriesAction(){
        $params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'catalog-choose' );
        return view('shop::catalog.categories', $params);
    }
}
