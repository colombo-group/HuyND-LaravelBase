<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Hash;
use App\User;
class UserController extends Controller
{
     /**
     * view login form
     *
     */
    public function login(){
        if(!Auth::check()) {
            return view('auth.login');
        }
        else return redirect()->route('home');
    }
    /**
    * get login's infor
     * check whether infor true or false
     *
     * @return path return home if login's infor true else return login with an erro
     */
    public function doLogin(Request $request){
        $email=$request->get('email');
        $pass=$request->get('password');
        $count=DB::table('users')->where('email',$email)->orwhere('username',$email)->count();
        if($count>0){
            $data=DB::table('users')->where('email',$email)->orwhere('username',$email)->first();
            $email=$data->email;
            $check_deleted=$data->deleted_at!=null?$data->deleted_at:null;
            if($check_deleted!=null){
                $erro="This account has been deleted";
                return redirect()->route('login',['erro'=>$erro]);
            }
            else if(Auth::attempt(array('email'=>$email_tmp,'password'=>$pass))){
                return redirect()->route('home');
            }

        }
        else {
            $erro="Password, Username or Email is incorrect";
            return redirect()->route('login',['erro'=>$erro]);
        }

    }

    /**
     * show list of user's accounts
     *
     * @return file and object
     */
    public function show(){
//        echo "ok";
        $data['user']=DB::table('users')->where('deleted_at','=',null)->paginate(4);
        return view('manage.list_user',$data);
    }

    /**
    * show form to edit user's infor
     *
     * @param integer $id id of this user's account
     * @return file and object or file
     */
    public function edit($id){
        $data['user']=DB::table('users')->where('id',$id)->first();
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
        if($request->get('email')!=null){
            $email=$request->get('email');
            $data=DB::table('users')->where('email',$email)->where('id','!=',$id)->count();
            if($data>0){
                $erro="Email".$email." existed!!";
                return redirect()->route('edit_user',['erro_exist1'=>$erro,'id'=>$id]);
            }
            DB::table('users')->where('id',$id)->update(array('email'=>$email));
        }
        if($request->get('username')!=null){
            $email=$request->get('username');
            $data=DB::table('users')->where('username',$email)->where('id','!=',$id)->count();
            if($data>0){
                $erro="Username ".$email." existed!!";
                return redirect()->route('edit_user',['erro_exist2'=>$erro,'id'=>$id]);
            }
            DB::table('users')->where('id',$id)->update(array('username'=>$email));
        }
        $fullname=$request->get('fullname');
        if($request->get('password1')!=null){
            if($request->get('password1')!=$request->get('password2')){
                $erro="Password isnot concidence";
                return redirect()->route('edit_user',['id'=>$id,'erro'=>$erro]);
            }
            else if($request->get('password1')==$request->get('password2')){
                $password=$request->get('password1');
                if(strlen($password)<6){
                    $erro="Password must have at least 6 characters";
                    return redirect()->route('edit_user',['id'=>$id,'erro'=>$erro]);
                }
                $password=Hash::make($password);
                DB::table('users')->where('id',$id)->update(array('password'=>$password));
            }

    	}
        $gender=$request->get('gender');
        $slogan=$request->get('slogan')!=null?$request->get('slogan'):'';
        $birthday=$request->get('birthday')!=null?$request->get('birthday'):null;
        $address=$request->get('address')!=null?$request->get('address'):'';
        DB::table('users')->where('id',$id)->update(array('name'=>$fullname,'gender'=>$gender,'slogan'=>$slogan,'birthday'=>$birthday,'address'=>$address));
        return redirect()->route('list_user');
    }

    /**
    * delete temporary user
     *
     * @param integer $id
     * @return path or file
     */
    public function delete($id){
        $user=DB::table('users')->where('id',$id)->first();
        if(Auth::user()->id_acc==1&&$user->id_acc==2) {
            User::where('id', $id)->delete();
            return redirect()->route('deleted_user');
        }
        else return view('manage.not_found');
    }

    /**
    * show list of deleted users
     */
    public function Deleted_User(){
        if(Auth::user()->id_acc==1) {
            $data['deleted_users'] = DB::table('users')->where('deleted_at', '!=', null)->paginate(4);
            return view('manage.list_deleted_users', $data);
        }
        else return view('manage.not_found');
    }
    /**
    * restore deleted temporary user
     */
    public function restore($id){
        User::withTrashed()->where('id',$id)->restore();
        return redirect()->route('list_user');
    }

    /**
    * delete user forever and can't restore
     */
    public function Delete_Forever($id){
        if(Auth::user()->id_acc==1) {
            User::where('id', $id)->forceDelete();
            return redirect()->route('deleted_user');
        }
        else return view('manage.not_found');
    }


}
