<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewsController extends Controller
{
    /**
    * show list of news
     *
     * @return file and object
     */
    public function show(){
        $data['news']=DB::table('news')->paginate(4);
//        print_r($data);
        return view('manage.list_news',$data);
    }

    /**
    * show adding news view
     */
    public function add(){
        return view('manage.add_edit_news');
    }

    /**
    * get new news infor and add it
     *
     * @return path
     */
    public function do_Add(Request $request){
        $title=$request->get('title');
        $count=DB::table('news')->where('title',$title)->count();

        $img=$request->file('img')->getClientOriginalName();
        $img=time().'_'.$img;
        $request->file('img')->move('upload/news',$img);
        $content=$request->get('content');
        if($count!=0){
            $erro="News existed";
            return redirect()->route('add_news',['erro'=>$erro,'content'=>$content]);
        }

        $created_at=date('Y-m-d G:i:s');
        DB::table('news')->insert(array('title'=>$title,'img'=>$img,'content'=>$content,'created_at'=>$created_at));
        return redirect()->route('news');

    }

    /**
    * show editing news view
     */
    public function edit(Request $request, $id){
        $arr['arr']=DB::table('news')->where('id',$id)->first();
        return view('manage.add_edit_news',$arr);
    }

    /**
    * get editing news infor and update
     *
     * @param integer $id news needing to edit
     * @return path
     */
    public function do_Edit(Request $request, $id){
        $title=$request->get('title');
        $count=DB::table('news')->where('title',$title)->where('id','!=',$id)->count();
        if($count>0){
            $erro='Title of News has been existed';
            return redirect()->route('edit_news',['erro'=>$erro,'id'=>$id]);
        }
        $img=$request->get('img2');
        if($request->hasFile('img')){
            $img=DB::table('news')->where('id',$id)->first();
            unlink("upload/news/".$img->img);
            $img=time()."_".$request->file('img')->getClientOriginalName();
            $request->file('img')->move('upload/news/',$img);
        }
        $content=$request->get('content');
        $updated_at=date('Y-m-d G:i:s');
        DB::table('news')->where('id',$id)->update(array('title'=>$title,'img'=>$img,'content'=>$content,'updated_at'=>$updated_at));
        return redirect()->route('news');
    }

    /**
     * delete a detail news
     *
     * @param integer $id news needing to delete
     * @return path
     */
    public function delete($id){
        $news=DB::table('news')->where('id',$id)->first();
        unlink('upload/news/'.$news->img);
        DB::table('news')->where('id',$id)->delete();
        return redirect()->route('news');
    }
}
