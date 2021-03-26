<?php


namespace App\Http\Controllers;


class TestController extends Controller
{
        public function testPage(){


            return view('test.test-page',['title'=>'fdfd']);


        }




}