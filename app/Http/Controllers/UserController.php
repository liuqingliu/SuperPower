<?php
/**
 * Created by IntelliJ IDEA.
 * User: liuqing
 * Date: 2018/8/9
 * Time: 7:39
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('center/index');
    }
}