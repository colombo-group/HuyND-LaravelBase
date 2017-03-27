<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MypageController extends Controller
{
    /**
    * view home's interface
     *
     * @return file home's file
     */
    public function Home(){
        return view('frontend.content.home');
    }

    /**
    * show list of news
     *
     * @return file and object
     */
    public function List_News(){
        $data['news']=DB::table('news')->paginate(5);
        return view('frontend.content.list_news',$data);
    }

    /**
    * show a detail news
     *
     * @param integer $id id of a news
     * @return file and object
     */
    public function news_Content(Request $request,$id){
        $data['content']=DB::table('news')->where('id',$id)->first();
        return view('frontend.content.news_content',$data);
    }
}
