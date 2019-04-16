<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 11/04/2019
 * Time: 16:04
 */

namespace App\Http\Controllers;


class ProdAccountController extends Controller
{
        public function indexAction(){
            $params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'prodaccount-index' );
            return view('shop::prodaccount.index', $params);
        }
}
