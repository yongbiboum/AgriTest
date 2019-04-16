<?php
/**
 * Created by PhpStorm.
 * User: faya
 * Date: 11/04/2019
 * Time: 16:18
 */

namespace App\Http\Controllers;


class ControlAccountController
{
    public  function indexAction(){
        $params = app( 'Aimeos\Shop\Base\Page' )->getSections( 'control-index' );
        return view('shop::controlaccount.index', $params);
    }
}
