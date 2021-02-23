<?php


namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::with('Produk')->get(),200);
    }

    public function login(Request $request){
        $credentials = [
            'id' => $request->get('id'),
            'password' => $request->get('password'),
        ];
        //find email -> select -> if(password)
        $getEmail = DB::table('pegawai')->where('id_pegawai', $request->input('id'))->first();
        if($getEmail){
            if($getEmail->password == $request->input('password')){
                return response()->json(['pegawai'=>$getEmail->nama_pegawai],200);
            }else{
                return response()->json('ID Pegawai/ Password Salah', 401);
            }
        }
        else{
            return response()->json('Account Not Found',404);
        }
        $status = 401;
        $response = ['error' => 'Unauthorised'];
        return response()->json($response, $status);

    }
}
