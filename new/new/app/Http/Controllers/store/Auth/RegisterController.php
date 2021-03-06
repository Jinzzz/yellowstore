<?php

namespace App\Http\Controllers\store\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\Mst_store;
use App\Models\admin\Trn_store_otp_verify;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Crypt;
use Str;

use App\Models\admin\Country;
use App\Models\admin\District;
use App\Models\admin\Town;
use App\Models\admin\State;
use App\Models\admin\Mst_store_documents;


use App\Models\admin\Mst_business_types;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   public function __construct()
    {
        $this->middleware('guest:store');
    }

       public function showRegistrationForm()
    {

        $countries   = Country::all();
        $business_types = Mst_business_types::where('business_type_status','=',1)->get();
        return view('store.auth.register',compact('countries','business_types'));

    }


    public function GetState(Request $request)
    {
            $country_id = $request->country_id;
            //dd($country_id);
            $state = State::where("country_id",'=',$country_id)
            ->pluck("state_name","state_id");
            return response()->json($state);
    }

    public function GetCity(Request $request)
    {
            $state_id = $request->state_id;
            //dd($state_id);
            $city = District::where("state_id",'=',$state_id)
            ->pluck("district_name","district_id");
            return response()->json($city);
    }

    public function GetTown(Request $request)
    {
            $city_id = $request->city_id;
            //dd($city_id);
            $town = Town::where("district_id",'=',$city_id)
            ->pluck("town_name","town_id");
        //	echo $town;die;
            return response()->json($town);
    }

    function CheckEmail(Request $request)
    {

      $email = $request->email;
      $data = Mst_store::where('email', $email)
       	->count();

      if($data >0)
      {
       echo 'not_unique';
      }
      else
      {
       echo 'unique';
      }
     }

     function CheckMobile(Request $request)
     {

       $number = $request->number;
       $data = Mst_store::where('store_mobile', $number)
            ->count();

       if($data >0)
       {
        echo 'not_unique';
       }
       else
       {
        echo 'unique';
       }
      }

    public function storeRegistration(Request $request,Mst_store $store,Mst_store_documents $store_doc,
        Trn_store_otp_verify $otp_verify)
    {




            $validator = Validator::make($request->all(),
            [
                'store_name'                       => 'required|unique:mst_stores',
                'store_contact_person_phone_number'=> 'required',
                //'email'                            => 'required|unique:mst_stores',
                'store_mobile'                     => 'required|unique:mst_stores',
                'password'                         => 'required|min:5|same:password_confirmation',


             ],
            [
                'store_name.unique'                => 'Store name exists',
                'store_name.required'                => 'Store name required',
                'store_contact_person_phone_number.required' => ' Mobile required',
                //'email.required'                    => 'Email Required',
                'password.required'                  => 'Store password required',
                'store_mobile.required'                  => 'Store mobile number required',
                'store_mobile.unique'                  => 'Store mobile number already exists ',

            ]);
          // $this->uploads($request);

            if(!$validator->fails())
            {
            $data= $request->except('_token');

            // echo "<pre>";
            // print_r($data);die;

             //$user_data =new User();

            $store->store_name            = $request->store_name;
            $store->store_name_slug       =Str::of($request->store_name)->slug('-');
            $store->store_contact_person_phone_number = $request->store_contact_person_phone_number;
            // $store->email   = $request->email;

            $store->store_mobile   = $request->store_mobile;

            $store->store_added_by        = 0;
            $store->password              = Hash::make($request->password);
            $store->store_account_status       = 0;
            $store->store_otp_verify_status    = 0;

            $store->store_contact_person_name            = $request->store_contact_person_name;
            $store->store_primary_address            = $request->store_contact_address;
            $store->store_country_id            = $request->store_country_id;
            $store->store_state_id            = $request->store_state_id;
            $store->store_district_id            = $request->store_district_id;
            $store->town_id            = $request->store_town_id;
            $store->place            = $request->store_place;
            $store->business_type_id            = $request->business_type_id;
            $store->store_username            = $request->username;

            $timestamp = time();
            \QrCode::format('svg')->size(500)->generate($timestamp,public_path().'/assets/uploads/store_qrcodes/'.$timestamp.'.svg');
            $store->store_qrcode          = $timestamp;

            $store->save();
            $store_id = DB::getPdo()->lastInsertId();

            $store_doc->store_id            = $store_id;
            $store_doc->store_document_gstin            = $request->store_gst_number;
            $store_doc->save();

            //dd($store_id);
            $store_otp =  rand ( 1000 , 9999 );
            //dd($store_otp);

            $store_otp_expirytime = Carbon::now()->addMinute(10);

            $otp_verify->store_id                 = $store_id;
            $otp_verify->store_otp_expirytime     = $store_otp_expirytime;
            $otp_verify->store_otp                 = $store_otp;
            $otp_verify->save();

        return redirect('store/registration/otp_verify/view/'.Crypt::encryptString($store_id));

    }else
    {
        //return redirect('/')->withErrors($validator->errors());
        return redirect()->back()->withErrors($validator)->withInput();
    }

    }

    public function otpVerificationview(Request $request, $id)
    {
        //dd($otp_id);
       // $otp_verify = TrnOTPVerify::Find($otp_id);
        $decrId  = Crypt::decryptString($id);
        $stores = Mst_store::Find($decrId);

        return view('store.auth.otp_verification',compact('stores'));
    }
public function otpVerification(Request $request,
                    Trn_store_otp_verify $otp_verify,$store_id)
    {


        $store_id  = $request->store_id;
        //dd($store_id);

       // $cus_otp_availability =  TrnOTPVerify::where('store_id', '=', $store_id)->first();
        // dd($cus_otp_availability);
        $otp_verify =  Trn_store_otp_verify::where('store_id', '=', $store_id)->first();
        if($otp_verify)
           {
        $store_otp_exp_time = $otp_verify->store_otp_expirytime;
        //  dd($cus_otp_exp_time);
        $current_time = Carbon::now()->toDateTimeString();
        // dd($current_time);
            $store_new_otp =  $otp_verify->store_otp;

             if($store_new_otp == $request->store_otp)

                {

                if($current_time < $store_otp_exp_time)
                {

                       $store = Mst_store::Find($store_id);
                      // dd($store);
                       $store->store_account_status = 1;
                       $store->store_otp_verify_status = 1;
                       $store->update();

                      return redirect('store-registration')->with('status','OTP verified successfully.');
                      // REDIRECT TO LOGIN PAGE
                    } else
                    {
                       return redirect()->back()->with('expiry_error','OTP expired.click on resend OTP.');
                    }

                }else{


                    return redirect()->back()->with('validation_error','Incorrect OTP entered. Please enter a valid OTP.');
                }


            }else
            {
                 return redirect()->back()->with('validation_error','Store OTP not found. Please click on resend OTP.');

            }

}

public function ResendOTP(Request $request,Mst_store $store,$store_id, Trn_store_otp_verify $otp_verify )
{
    //dd($store_id);
    $otp_verify = Trn_store_otp_verify::where('store_id','=',$store_id)->first();
   // dd($otp_verify);
    if($otp_verify !== null){
       // dd('string');

    $store_otp_verify_id = $otp_verify->store_otp_verify_id;
   // dd($store_otp_verify_id);
    $otp_verify = Trn_store_otp_verify::Find($store_otp_verify_id);
    $extented_time = Carbon::now()->addMinute(10);
     //dd($extented_time);
    $otp_verify->store_otp_expirytime = $extented_time;

    $otp_verify->update();

    return redirect()->back()->with('status','OTP resended successfully');

        }else
        {
             $otp_verify = new Trn_store_otp_verify;
             $store_otp =  rand ( 1000 , 9999 );
            //dd($store_otp);

            $store_otp_expirytime = Carbon::now()->addMinute(10);

            $otp_verify->store_id                 = $store_id;
            $otp_verify->store_otp_expirytime     = $store_otp_expirytime;
            $otp_verify->store_otp                 = $store_otp;
            $otp_verify->save();
            return redirect()->back()->with('status','OTP registerd successfully. Please verify OTP');

        }
}


public function getemail(Request $request)
{
            $email = $request->email;
                //dd($country_id);
                $email = Trn_casab_store::where("email",'=',$email)
                ->pluck("email","store_id");
                return response()->json($email);
}
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
       protected function guard()
    {
        return Auth::guard('store');
    }
}
