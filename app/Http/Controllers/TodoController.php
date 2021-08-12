<?php

namespace App\Http\Controllers;

use App\todo;
use App\Todos;
use App\User;
use App\Answer;
use App\question;  
use App\Seo;  
use Auth;
use Redirect;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Post::class, 'user');
    }

    public function index(Request $request)
    {
         
        $title=$request->get('title');
        $profile_image=$request->get('profile_image');
        $searchdata = [];
        if(!empty($request->get('title'))) {
                $searchdata[]= ['title','like','%'.filter_var($request->get('title'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('profile_image'))) {
                $searchdata[]= ['original_image_name','=',filter_var($request->get('profile_image'),FILTER_SANITIZE_STRING)];
            }
            $viewdata = Seo::SearchUserData($searchdata);
            // dd($viewdata);
               return view('fetch_addeddata',compact('viewdata','title'))->with('no', 1);
            
            
        

    }

    public function regular(Request $request)
    {
         
        // $viewdata=todos::sortable()->paginate(10);
        // return view('fetch_addedData',compact('viewdata'))->with('no', 1);
        //$this->authorize('view', User::class);
        //$user_id=$id;
        $number=$request->get('number');
        $name=$request->get('search');
        $email=$request->get('email');
        $role=$request->get('role');
        $created_at=$request->get('created_at');
        $updated_at=$request->get('updated_at');
        $searchdata = [];
        if(!empty($id)) {
                $searchdata[]= ['user_id',filter_var($id,FILTER_VALIDATE_INT)];
            }
            if(!empty($request->get('search'))) {
                $searchdata[]= ['name','like','%'.filter_var($request->get('search'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('number'))) {
                $searchdata[]= ['number','=',filter_var($request->get('number'),FILTER_VALIDATE_INT)];
            }
            if(!empty($request->get('email'))) {
                $searchdata[]= ['email','like','%'.filter_var($request->get('email'),FILTER_SANITIZE_EMAIL).'%'];
            }            
            if(!empty($request->get('role'))) {
                $searchdata[]= ['role','like','%'.filter_var($request->get('role'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('created_at'))) {
                $searchdata[]= ['created_at','like','%'.filter_var($request->get('created_at'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('updated_at'))) {
                $searchdata[]= ['updated_at','like','%'.filter_var($request->get('updated_at'),FILTER_SANITIZE_STRING).'%'];
            }
            // if(!empty(Auth::user()->id)) {
            //     $searchdata[]= [filter_var(Auth::user()->id,FILTER_SANITIZE_STRING)];
            // }
            // if(!empty(Auth::user()->user_id)) {
            //     $searchdata[]= [filter_var(Auth::user()->user_id,FILTER_SANITIZE_STRING)];
            // }
            $userid=Auth::user()->id;
            $userType=Auth::user()->user_type; 
            $userData = Todos::SearchRegularData($searchdata,$userid,$userType);
               return view('fetch_addeddata',['viewdata'=>$userData,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
            
            
        

    }
    public function quiz(Request $request)
    {
         
        // $viewdata=todos::sortable()->paginate(10);
        // return view('fetch_addedData',compact('viewdata'))->with('no', 1);
        //$this->authorize('view', User::class);
        //$user_id=$id;
        $number=$request->get('number');
        $name=$request->get('search');
        $email=$request->get('email');
        $role=$request->get('role');
        $created_at=$request->get('created_at');
        $updated_at=$request->get('updated_at');
        $searchdata = [];
        if(!empty($id)) {
                $searchdata[]= ['user_id',filter_var($id,FILTER_VALIDATE_INT)];
            }
            if(!empty($request->get('search'))) {
                $searchdata[]= ['name','like','%'.filter_var($request->get('search'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('number'))) {
                $searchdata[]= ['number','=',filter_var($request->get('number'),FILTER_VALIDATE_INT)];
            }
            if(!empty($request->get('email'))) {
                $searchdata[]= ['email','like','%'.filter_var($request->get('email'),FILTER_SANITIZE_EMAIL).'%'];
            }            
            if(!empty($request->get('role'))) {
                $searchdata[]= ['role','like','%'.filter_var($request->get('role'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('created_at'))) {
                $searchdata[]= ['created_at','like','%'.filter_var($request->get('created_at'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('updated_at'))) {
                $searchdata[]= ['updated_at','like','%'.filter_var($request->get('updated_at'),FILTER_SANITIZE_STRING).'%'];
            }
            // if(!empty(Auth::user()->id)) {
            //     $searchdata[]= [filter_var(Auth::user()->id,FILTER_SANITIZE_STRING)];
            // }
            // if(!empty(Auth::user()->user_id)) {
            //     $searchdata[]= [filter_var(Auth::user()->user_id,FILTER_SANITIZE_STRING)];
            // }
            $userid=Auth::user()->id;
            $userType=Auth::user()->user_type; 
            $userData = Todos::SearchQuizData($searchdata,$userid,$userType);
               return view('fetch_addeddata',['viewdata'=>$userData,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
            
            
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userType=Auth::user()->user_type;
        // if($userType==1)
        // {
            return view('addData');
        // }else
        // {
        //     return redirect::back();
        // }
        
    }

    public function profile_Pic(Request $request){
        
        //dd($res);
        $res=new Seo;
        $res->title=$request->get('title');
        $res->description=$request->get('description');
        if ($request->hasfile('profile_image')) {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalExtension();
               $filename = time() . '.' . $extension;
               $file->move('user_profile_image/',$filename);
               $res->image = $filename;
           }   else{
            // return $request;
            // $res->profile_image = '';
            $request->session()->flash('msg','Not Update Image Sucessfull');
            return redirect()->route('alldata');
           }
           
        $res->save();
        $request->session()->flash('msg','Update Image Sucessfull');
         return redirect()->route('alldata');
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();
        $request->validate([
            'question'=>'required',
            'ans1'=>'required',
            'ans2'=>'required',
            'ans3'=>'required',
            'ans4'=>'required',
            'rans'=>'required'
        ]);
        $res=new Question;
        $res->question=$request->input('question');
        $res->ans1=$request->input('ans1');
        $res->ans2=$request->input('ans2');
        $res->ans3=$request->input('ans3');
        $res->ans4=$request->input('ans4');
        $res->rans=$request->input('rans');
        // $res->status=1;
        $res->user_id=Auth::user()->id;
        //$res->save();
           $userData = Question::InsertUserData($res);
        if ($res->save()) {
            $request->session()->flash('msg','Insert Sucessfull');
            return Redirect('fetch_addeddata');
        }else{
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }
        
        //return response()->json($res);
      }
    
 
    /**
     * Display the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function dashboardcountdata(todo $todo)
    {
        $count = todo::where('status',1)->get()->count();
        $trashdata = todos::onlyTrashed()->get()->count();
        $countuser = DB::table('users')->get()->count();
        $date = date('Y-m-d');
        // $time = Carbon::now();
        $var  = Carbon::now('Asia/Kolkata');
        $time = $var->toTimeString();
        return view('admin',compact('count','countuser','date','time','trashdata'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(todo $todo,$id)
    {
        $userid=Auth::user()->id;
        $Data_id = base64_decode($id);
        $userType=Auth::user()->user_type;
        $todoArr=Todo::where('user_id',$userid)->find($Data_id);
        if ($todoArr) {
           return view('editData')->with('todoArr',$todoArr);
        }
        elseif ($userType==1) {
            $todoArr=Todo::find($user_id);
            return view('editData')->with('todoArr',$todoArr);
        }
        else
        {
            return back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, todo $todo)
    {
        $request->validate([
            'name'=>'required | min:5',
            'mobile'=>'required | min:10',
            'email'=>['required', 'string', 'email', 'max:255'],
            'role'=>'required',
            'profile_image'=>'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        $res=Todos::find($request->id);
        $res->name=$request->input('name');
        $res->number=$request->input('mobile');
        $res->email=$request->input('email');
        $res->role=$request->input('role');
        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)){
              $request->session()->flash('msg','Email Invalid');
         return Redirect::back();
         }elseif(!filter_var($request->input('mobile'), FILTER_VALIDATE_INT)){
                $request->session()->flash('msg','Number Invalid');
         return Redirect::back();
            }
            elseif(!filter_var($request->input('name'), FILTER_SANITIZE_STRING)){
                $request->session()->flash('msg','Only string');
         return Redirect::back();
            }
        else{
        if ($request->hasfile('profile_image') !="") {
               $file = $request->file('profile_image');
               $extension = $file->getClientOriginalExtension();
               $filename = time() . '.' . $extension;
               $file->move('public/profile_image/',$filename);
               $res->image = $filename;
           }   
        //$res->save();
           $userData = Todos::UpdateUserData($res);
        if ($res->save()) {
            $request->session()->flash('msg','Updated Sucessfull');
            return Redirect('fetch_addeddata');
        }
        else
        {
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }

        
        //return response()->json($res);
       }
    }

    public function activeDactivateUser(Request $request){
        if (filter_var($request->active_id, FILTER_VALIDATE_INT))
        {
            $url = $request->input('current_url');
            $id = $request->input('active_id');
            $data= DB::table('todos')->where('id',$id)->get();
            $status=$data[0]->status;
            //print_r($url); die;
            if ($status==1) {
                $res=Todos::find($request->active_id);
                $res->status=0;
                //$res->save();
                $ActiveUserData = Todos::ActiveUserData($res);
            }else{
                $res=Todos::find($request->active_id);
                $res->status=1;
                //$res->save();
                $DactiveUserData = Todos::ActiveUserData($res);
            }
            //return Redirect('fetch_addeddata');
            //return Redirect::to(Input::get('redirects_to'));
            //return redirect('fetch_addeddata?page='.$page);
            return redirect($url);
        }
    }
    public function getusersData(Request $request)
    {
        $res=$request->input('email');
        $data= todo::where('email',$res)->get();
        return response()->json($data);
    }



    // public function search(Request $request)
    // {
        // $number=$request->get('number');
        // $name=$request->get('search');
        // $email=$request->get('email');
        // $role=$request->get('role');
        // $created_at=$request->get('created_at');
        // $updated_at=$request->get('updated_at');
        // $post=todos::where('name','like','%'.$request->search.'%')->where('number','like','%'.$request->number.'%')->where('email','like','%'.$request->email.'%')->where('role','like','%'.$request->role.'%')->where('created_at','like','%'.$request->created_at.'%')->where('updated_at','like','%'.$request->updated_at.'%')->paginate(10);
        // //print_r($post); die;
        // return view('fetch_addeddata',['viewdata'=>$post,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
    // }

    public function deletedsearch(Request $request)
    {
        $number=$request->get('number');
        $name=$request->get('search');
        $email=$request->get('email');
        $role=$request->get('role');
        $created_at=$request->get('created_at');
        $updated_at=$request->get('updated_at');
        $deletesearchdata = [];
            if(!empty($request->get('search'))) {
                $deletesearchdata[]= ['name','like','%'.filter_var($request->get('search'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('number'))) {
                $deletesearchdata[]= ['number','like','%'.filter_var($request->get('number'),FILTER_VALIDATE_INT).'%'];
            }
            if(!empty($request->get('email'))) {
                $deletesearchdata[]= ['email','like','%'.filter_var($request->get('email'),FILTER_SANITIZE_EMAIL).'%'];
            }            
            if(!empty($request->get('role'))) {
                $deletesearchdata[]= ['role','like','%'.filter_var($request->get('role'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('created_at'))) {
                $deletesearchdata[]= ['created_at','like','%'.filter_var($request->get('created_at'),FILTER_SANITIZE_STRING).'%'];
            }
            if(!empty($request->get('updated_at'))) {
                $deletesearchdata[]= ['updated_at','like','%'.filter_var($request->get('updated_at'),FILTER_SANITIZE_STRING).'%'];
            }
        //$post=todos::where($searchdata)->onlyTrashed()->paginate(10);
        $userData = Todos::DeleteSearchUserData($deletesearchdata);
        //print_r($post); die;
        return view('deleted',['viewdata'=>$userData,'search'=>$name,'number'=>$number,'email'=>$email,'role'=>$role,'created_at'=>$created_at,'updated_at'=>$updated_at])->with('no', 1);
    }

    // public function examsearch(Request $request,todo $todo)
    // {
    //     if($request->ajax()){
    //         $search = $request->get('search');
    //         //print_r($search); die;
    //          $search = str_replace(" ", "%", $search);
    //         $viewdata=todos::where('name','like','%'.$search.'%')->orWhere('number','like','%'.$search.'%')->get();
    //         // print_r($viewdata); die;
    //         return view('include.all_data',compact('viewdata'))->with('no', 1);
    //         //echo json_encode($viewdata);
    //     }
    // }
     
     /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function rowfilter(Request $request)
    {
        if (filter_var($request->rowdataget, FILTER_VALIDATE_INT))
        {
            $data=$request->get('rowdataget');
            //$viewuserdata=todos::paginate($data);
            $rowfilteruserData = Todos::RowFilterUserData($data);
            return view('fetch_addedData',['viewdata'=>$rowfilteruserData,'rowfilter'=>$data,])->with('no', 1);
        }
    }
    public function deletedrowfilter(Request $request)
    {
        if (filter_var($request->rowdataget, FILTER_VALIDATE_INT))
        {
            $data=$request->get('rowdataget');
            //$viewuserdata=todos::onlyTrashed()->paginate($data);
            $DeletedrowfilteruserData = Todos::DeletedRowFilterUserData($data);
            return view('deleted',['viewdata'=>$DeletedrowfilteruserData,'rowfilter'=>$data,])->with('no', 1);
        }
    }

    public function Email_already(Request $request){
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL))
        {
            $data=$request->email;
            //$checkEmail=todo::where('email',$request->email)->first();
            $checkEmail = Todos::CheckEmail($data);
            if ($checkEmail) {
                echo 'false';
            }else
            {
                echo "true";
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, todo $todo)
    {
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
          $id = $request->input('deleteid');
          // print_r($id); die;
          $userdata=Todos::find($id);
         //print_r($userdata); die;
        if (!$userdata) {
            return 'Not delete';
        }
        if ($userdata->delete()) {
            return back()->with('status','user data delete sucessfull');
            # code...
        }
        // return Redirect('fetch_addeddata');
        }else{
            return back();
        }
    }

    public function viewdata(Request $request, todo $todo)
    {
        if (filter_var($request->input('row'), FILTER_VALIDATE_INT))
        {
            // $request->session()->flash('msg','Please use right way!!!');
            // return Redirect::back();
        $id=$request->input('row');
         $data=Question::where('id',$id)->get();
         $data .= "
            <tr style='background: #f4f6f9'>
                  <th>Question:</th>
                  <td>".$data[0]->question."</td>
             </tr><tr>
                  <th>Answer1:</th>
                  <td>".$data[0]->ans1."</td>
             </tr><tr>
                  <th>Answer2:</th>
                  <td>".$data[0]->ans2."</td>
             </tr><tr>
                  <th>Answer3:</th>
                  <td>".$data[0]->ans3."</td>

             </tr><tr>
                  <th>Answer4:</th>
                  <td>".$data[0]->ans4."</td>

             </tr>";
          echo $data;
      }
      else
      {
        return back();
         //return $this->request->setJSON($data);
      }
    }
    public function deleteddata(){
        $userid=Auth::user()->id;
        $userType=Auth::user()->user_type;
        if ($userType==1) {
            $viewdata=todos::sortable()->onlyTrashed()->paginate(10);
        }
        else
        {
            $viewdata=todos::where('user_id',$userid)->sortable()->onlyTrashed()->paginate(10);
        }
        
        return view('deleted',compact('viewdata'))->with('no', 1);
    }
    public function restore(Request $request){
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
            // $request->session()->flash('msg','Please use right way!!!');
            // return Redirect::back();
        $id = $request->input('deleteid');
        //print_r($id); die;
        //todos::withTrashed()->find($id)->restore();
        $restore = Todos::RestoreData($id);
        return redirect()->route('deleted')
            ->with('success', 'You successfully restored the project');
        }
        else
        {
            return back();
        }
    }
    public function forcedelete(Request $request){
        if (filter_var($request->input('deleteid'), FILTER_VALIDATE_INT))
        {
        $id = $request->input('deleteid');
        //use model
              todos::where('id', $id)->forceDelete();
        //end model
        return redirect()->route('deleted')
            ->with('success', 'You successfully restored the project');
        }
        else
        {
            return back();
        }
    }

    public function export(Request $request) 
    {
        
        // $data=$request->search;
        // $data=$request->email;
        return Excel::download(new UsersExport($request->search,$request->email,$request->name,$request->role,$request->created_at,$request->updated_at), 'users.xlsx');
    }
    

    // public function getaddtype($id)
    // {
        
    //     $userData=Todos::where('id',$id)->get();
    //     //dd($userData);
    //     // $data =session()->all();
    //            //print_r($userData); die;
    //            return view('fetch_addeddata',['adddatatype'=>$userData])->with('no', 1);


    //         // return view('question');
        
        
    // }



    public function adddataforuser(Request $request)
    {
        $qid=$request->input('row');
        // dd($id);
        $res=new Todos;
        //$qid=$request->input('qid');
        $getdata=Question::where('id',$qid)->first();

        $question=$getdata->question;
        
        $ans1=$getdata->ans1;
        $ans2=$getdata->ans2;
        $ans3=$getdata->ans3;
        $ans4=$getdata->ans4;
        $rans=$getdata->rans;
        $res->question=$question;
        $res->ans1=$ans1;
        $res->ans2=$ans2;
        $res->ans3=$ans3;
        $res->ans4=$ans4;
        $res->rans=$rans;
        $res->type='r';
        // $res->status=1;
        
        $res->user_id=Auth::user()->id;
        //$res->save();
        //dd($res->user_id=Auth::user()->id);
           $userData = Todos::InsertUserData($res);
         
        if ($res->save()) {
            $request->session()->flash('msg','Insert Sucessfull');
            return Redirect('fetch_addeddata');
        }else{
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }
        
        //return response()->json($res);
      }

      public function adddataquizforuser(Request $request)
    {
        $qid=$request->input('row');
        // dd($id);
        $res=new Todos;
        //$qid=$request->input('qid');
        $getdata=Question::where('id',$qid)->first();

        $question=$getdata->question;
        
        $ans1=$getdata->ans1;
        $ans2=$getdata->ans2;
        $ans3=$getdata->ans3;
        $ans4=$getdata->ans4;
        $rans=$getdata->rans;
        $res->question=$question;
        $res->ans1=$ans1;
        $res->ans2=$ans2;
        $res->ans3=$ans3;
        $res->ans4=$ans4;
        $res->rans=$rans;
        $res->type='q';
        // $res->status=1;
        
        $res->user_id=Auth::user()->id;
        //$res->save();
        //dd($res->user_id=Auth::user()->id);
           $userData = Todos::InsertUserData($res);
         
        if ($res->save()) {
            $request->session()->flash('msg','Insert Sucessfull');
            return Redirect('fetch_addeddata');
        }else{
            return Redirect::back()->with('msg','Somthing Went Error!!!!');
        }
        
        //return response()->json($res);
      }
    public function getaddtype(Request $request)
    {
        if (filter_var($request->input('row'), FILTER_VALIDATE_INT))
        {
        $id=$request->input('row');
        
         $data=Question::where('id',$id)->get();
         $data .= "
             <tr>
                  
                   <td>Are You Sure You Are Adding This..</td>
             </tr>
            <tr class='crtarddata'>
                  
                   <td><input name='qid' type='text' value=".$data[0]->id."></td>
            </tr>
             <tr class='type'>
                  <th>Type:</th>
                  <td><select class='form-control' id='exampleFormControlSelect1' name='qtype'>
                  <option value='r'>Regular</option>
                  <option value='q'>Quiz</option>
                  </select></td>

             </tr>";
          echo $data;
      }
      else
      {
        return back();
         //return $this->request->setJSON($data);
      }
    }
    public function start_exam(Request $request)
    {
         $type=$request->input('type');
         Session::put("nextq",'1');
         Session::put("wrongans",'0');
         Session::put("correctans",'0');
         Session::put("noans",'0');
         Session::put("type",$type);
        $userData=Todos::where(['type'=>$type,'status'=>'1'])->first();
        // $data =session()->all();
               //dd($userData);
               return view('question',['viewdata'=>$userData])->with('no', 1);


            // return view('question');
        
        
    }

    public function exampage()
    {
        return view('exam');
    }


    public function answer(Request $request)
    {
        // $res=new Answer;
        // $questionid=$request->input('questionid');
        // $userans   =$request->input('userans');
        // $id=Auth::user()->id;
        // $countanswer=0;
        // $totalatquestion=0;
        // if(!empty($questionid))
        // {
        //     $query=Todos::where('id',$questionid)->get();
        //     $rightans=$query[0]->rans;
        //     //dd($rightans[0]->rans);
        //     $getuserdata=Answer::where('id',$id)->get();
        //     if ($getuserdata=="")
        //     {
               
        //        if($userans==$rightans)
        //        {
        //         //dd($res->totalquestion=$totalatquestion);
        //         $res->totalquestion=$totalatquestion+1;
        //        $res->totalanswer=$countanswer+1;
        //        $res->id=$id;
        //        }
        //        else
        //        {
        //         $res->totalquestion=$totalatquestion+1;
        //        }
        //        $res->save();
        //     }
        //     else
        //     {
        //         $res=Answer::find($id);
        //         $countques=$getuserdata[0]->totalquestion;
        //         $countans=$getuserdata[0]->totalanswer;
        //         if($userans==$rightans)
        //        {
        //         $res->totalquestion=$countques+1;
        //         $res->totalanswer=$countans+1;
        //         }
        //        else
        //        {
        //         $res->totalquestion=$countques+1;
        //        }
        //         $res->save();
        //     }
            
            
        // }
        // return view('question');


        $type=$request->input('type');
        $res=new Answer;
        $nextq=Session::get('nextq');
        $wrongans=Session::get('wrongans');
        $correctans=Session::get('correctans');
        $noans=Session::get('noans');
        $type=Session::get('type');
         //dd($request->ans);
        $nextq+=1;
        if($request->userans==$request->ans)
        {
            $correctans+=1;
        }
        else
        {
            if($request->userans =="")
            {
                $noans+=1;

            }
            else
            {
                $wrongans+=1;
            }
            
        }
        Session::put("nextq",$nextq);
        Session::put("wrongans",$wrongans);
        Session::put("correctans",$correctans);
        Session::put("noans",$noans);

        $i=0;
        $question=Todos::where(['type'=>$type,'status'=>'1'])->get();
        foreach ($question as $squestion) 
        {
            $i++;
            if($question->count()< $nextq)
            {
                $res->totalquestion=$question->count();
                $res->wrongans=$wrongans;
                $res->correctanswer=$correctans;
                $res->noanswer=$noans;
                $res->save();
                return view('profile');
            }
            if($i==$nextq)
            {
                //return view('question')->with(['viewdata'=>$question]);
                return view('question',['viewdata'=>$squestion])->with('no', 1);

            }
        }


    }
}
