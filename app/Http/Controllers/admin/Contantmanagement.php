<?php

namespace App\Http\Controllers\Admin;
use App\Models\User_faq;
use App\Models\Content_management;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables; 
class Contantmanagement extends Controller
{
    
    public function index(){
        $id = '1';
        $data = Content_management::findOrFail($id);
        return view('admin/contentmangement/user',compact('data'));
    }
    public function storePrivacy(Request $request){
        $general = Content_management::find($request->id);
        $general->user_privacy_policy = $request->user_privacy_policy;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Privacy Policy  Update Successfully');
    }
    public function storeVendorTC(Request $request){
        $general = Content_management::find($request->id);
        $general->terms_conditions_user = $request->terms_conditions_user;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Vendor Terms & Condition  Update Successfully');
    }
    public function storeCheflabTC(Request $request){
        $general = Content_management::find($request->id);
        $general->terms_conditions_cheflab = $request->terms_conditions_cheflab;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Cheflab Terms & Condition  Update Successfully');
    }
    public function storeRefund(Request $request){
        $general = Content_management::find($request->id);
        $general->refund_cancellation_user = $request->refund_cancellation_user;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Cheflab Terms & Condition  Update Successfully');
    }
    public function user_faq(){
        return view('admin/contentmangement/userfaq');
    }
    public function store_faq(Request $request){
        $this->validate($request, [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);
        $faq = new User_faq;
        $faq->faq_question = $request->faq_question;
        $faq->faq_answer = $request->faq_answer;
        $faq->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'FAQ Create Successfully');
    }
    public function getFaq(Request $request){
        if ($request->ajax()) {

            $data = User_faq::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'.route('admin.user.faqedit',Crypt::encryptString($data->id)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="FAQ" table="' . Crypt::encryptString('user_faq') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })



                ->rawColumns(['date','action-js'])
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function fun_edit_faq($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $faq = User_faq::findOrFail($id);
           // dd($city_data);
            return view('admin/setting/editfaq',compact('faq'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function update_faq(Request $request){
        $this->validate($request, [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);
        $faq = User_faq::find($request->id);
        $faq->faq_question = $request->faq_question;
        $faq->faq_answer = $request->faq_answer;
        $faq->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'FAQ Update Successfully');
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = User_faq::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'FAQ Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            }



        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
}