<?php

namespace App\Http\Controllers\manage;
use App\Repository\NewsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;


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
        $data['news']=$this->repo->paginate(5);
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
    public function do_add(Request $request){
        $img=$request->file('img')->getClientOriginalName();
        $img_tag=$request->file('img')->getClientOriginalExtension();
        if($img_tag!="jpg"&&$img_tag!="png"){
            $erro_img="Image is not valid!";
            return redirect()->route('add_news',['erro_img'=>$erro_img]);
        }
        $img=time().'_'.$img;
        $request->file('img')->move('upload/news',$img);
        $content=$request->get('content');
        $title=["title"=>$request->get('title')];
        $rules = array('title' => 'unique:news,title');
        $validate= Validator::make($title,$rules);
        if($validate->fails()){
            $erro="News existed";
            return redirect()->route('add_news',['erro'=>$erro,'content'=>$content]);
        }
        echo 'ok';
        $attr=['title'=>$title['title'],'img'=>$img,'content'=>$content];
        $this->repo->firstOrCreate($attr);
        return redirect()->route('news');

    }

    /**
     * show editing news view
     */
    public function edit(Request $request, $id){
        $arr['arr']=$this->repo->find($id);
        return view('manage.add_edit_news',$arr);
    }

    /**
     * get editing news infor and update
     *
     * @param integer $id news needing to edit
     * @return path
     */
    public function do_Edit(Request $request, $id){
        $title=array('title'=>$request->get('title'));
        $validate=Validator::make($title,array('title'=>'unique:news,title,'.$id.',id'));
        if($validate->fails()){
            $erro='News has been existed';
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
            $img=$this->repo->find($id);
            unlink("upload/news/".$img->img);
            $img=time()."_".$request->file('img')->getClientOriginalName();
            $request->file('img')->move('upload/news/',$img);
        }

        $content=$request->get('content');
        $attr=array('title'=>$title['title'],'img'=>$img,'content'=>$content);
        $this->repo->update($attr,$id);
        return redirect()->route('news');
    }

    /**
     * delete a detail news
     *
     * @param integer $id news needing to delete
     * @return path
     */
    public function delete($id){
        $news=$this->repo->find($id);
        unlink('upload/news/'.$news->img);
        $this->repo->delete($id);
        return redirect()->route('news');
    }
}
