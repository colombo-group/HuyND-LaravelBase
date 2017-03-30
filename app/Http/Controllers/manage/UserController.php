<?php

namespace App\Http\Controllers\manage;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;


class UserController extends Controller
{
    private $repo;
    public function __construct(UserRepository $repo)
    {
        $this->repo=$repo;
    }

    /**
     * show list of user's accounts
     *
     * @return file and object
     */
    public function show(){
        $data['user']=$this->repo->paginate(5);
        return view('manage.list_user',$data);
    }

    /**
     * show form to edit user's infor
     *
     * @param integer $id id of this user's account
     * @return file and object or file
     */
    public function edit($id){
        $data['user']=$this->repo->find($id);
        if(Auth::id()==$id||(Auth::user()->id_acc==1&&$data['user']->id_acc==2)) {
            return view('manage.edit_user', $data);
        }
        else return view('manage.not_found');
    }

    /**
     * get edited user's infor and check
     *
     * @param $id
     * @return path
     */
    public function do_edit(Request $request,$id){
        //check email existed or not
            $email=["email"=>$request->get('email'),"username"=>$request->get('username')];
            $rules = array('email' => 'unique:users,email,'.$id.',id');
            $validate= Validator::make($email,$rules);
            if($validate->fails()) {
                $erro = "Email " . $email['email'] . " existed!!";
                return redirect()->route('edit_user', ['erro_exist1' => $erro, 'id' => $id]);
            }
        //check username existed or not
            $rules = array('username' => 'unique:users,username,'.$id.',id');
            $validate= Validator::make($email,$rules);
            if($validate->fails()){
                $erro="Username ".$email['username']." existed!!";
                return redirect()->route('edit_user',['erro_exist2'=>$erro,'id'=>$id]);
            }
            $fullname=$request->get('fullname');
        if($request->get('password1')!=null){
            if($request->get('password1')!=$request->get('password2')||strlen($request->get('password1'))<6){
                $erro="Password isnot concidence or less than 6 characters";
                return redirect()->route('edit_user',['id'=>$id,'erro'=>$erro]);
            }
            else{
                $password=$request->get('password1');
                $password=Hash::make($password);
                $attr=['password'=>$password];
                $this->repo->update($attr,$id);
            }
        }
        $gender=$request->get('gender');
        $slogan=$request->get('slogan')!=null?$request->get('slogan'):'';
        $birthday=$request->get('birthday')!=null?$request->get('birthday'):null;
        $address=$request->get('address')!=null?$request->get('address'):'';
        $attr=['email'=>$email['email'],'username'=>$email['username'],'name'=>$fullname,'gender'=>$gender,'slogan'=>$slogan,'birthday'=>$birthday,'address'=>$address];
        $this->repo->update($attr,$id);
        return redirect()->route('list_user');
    }

    /**
     * delete temporary user
     *
     * @param integer $id
     * @return path or file
     */
    public function delete($id){
        $user=$this->repo->find($id);
        if(Auth::user()->id_acc==1&&$user->id_acc==2) {
            $this->repo->softDel($id);
            return redirect()->route('deleted_user');
        }
        else return view('manage.not_found');
    }

    /**
     * show list of deleted users
     */
    public function Deleted_User(){
        if(Auth::user()->id_acc==1) {
            $deleted_users['deleted_users']=$this->repo->getDeletedRecord(4);
            return view('manage.list_deleted_users', $deleted_users);
        }
        else return view('manage.not_found');
    }
    /**
     * restore deleted temporary user
     */
    public function restore($id){
        $this->repo->restore($id);
        return redirect()->route('list_user');
    }

    /**
     * delete user forever and can't restore
     */
    public function Delete_Forever($id){
        if(Auth::user()->id_acc==1) {
            $this->repo->forceDel($id);
            return redirect()->route('deleted_user');
        }
        else return view('manage.not_found');
    }


}
