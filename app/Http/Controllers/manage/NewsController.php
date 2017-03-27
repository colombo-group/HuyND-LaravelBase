<?php

namespace App\Http\Controllers\manage;
use App\Repository\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    private $repo;
    public function __construct(NewsRepository $repo)
    {
        $this->repo=$repo;
    }

    /**
     * show list of news
     *
     * @return file and object
     */
    public function show(){
        $data['news']=$this->repo->getAll(4);
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
        $count=$this->repo->count('title','=',$title);
        $img=$request->file('img')->getClientOriginalName();
        $img_tag=$request->file('img')->getClientOriginalExtension();
        if($img_tag!="jpg"&&$img_tag!="png"){
            $erro_img="Image is not valid!";
            return redirect()->route('add_news',['erro_img'=>$erro_img]);
        }

        $img=time().'_'.$img;
        $request->file('img')->move('upload/news',$img);
        $content=$request->get('content');
        if($count!=0){
            $erro="News existed";
            return redirect()->route('add_news',['erro'=>$erro,'content'=>$content]);
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $created_at=date('Y-m-d G:i:s');
        $attr=array('title'=>$title,'img'=>$img,'content'=>$content,'created_at'=>$created_at);
        $this->repo->create($attr);
        return redirect()->route('news');

    }

    /**
     * show editing news view
     */
    public function edit(Request $request, $id){
        $arr['arr']=$this->repo->getOneRecord('id',$id);
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
        $count=$this->repo->checkConcidence($id,'title',$title);
        if($count>0){
            $erro='Title of News has been existed';
            return redirect()->route('edit_news',['erro'=>$erro,'id'=>$id]);
        }
        if($request->hasFile('img')) {
            $img_tag = $request->file('img')->getClientOriginalExtension();
            if ($img_tag != "jpg" && $img_tag != "png") {
                $erro_img = "Image is not valid!";
                return redirect()->route('edit_news', ['erro_img' => $erro_img, 'id' => $id]);
            }
        }
        $img=$request->get('img2');
        if($request->hasFile('img')){
            $img=$this->repo->getOneRecord('id',$id);
            unlink("upload/news/".$img->img);
            $img=time()."_".$request->file('img')->getClientOriginalName();
            $request->file('img')->move('upload/news/',$img);
        }

        $content=$request->get('content');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $updated_at=date('Y-m-d G:i:s');
        $attr=array('title'=>$title,'img'=>$img,'content'=>$content,'updated_at'=>$updated_at);
//        $this->repo->update($attr,$id);
//        return redirect()->route('news');
    }

    /**
     * delete a detail news
     *
     * @param integer $id news needing to delete
     * @return path
     */
    public function delete($id){
        $news=$this->repo->getOneRecord('id',$id);
        unlink('upload/news/'.$news->img);
        $this->repo->delete($id);
        return redirect()->route('news');
    }
}
