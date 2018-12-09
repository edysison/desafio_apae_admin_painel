<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investment;
use App\Donation;
use DB;
use Illuminate\Support\Facades\URL;

class ApiController extends Controller
{
    public function transaction(Request $request)
    {
        $donation = Donation::get();
        $investment = Investment::get();
        return response()->json([
            'donation'=>$donation,
            'investment'=>$investment,
        ], 201);
    }

    public function dateTransaction($dateMin)
    {
        // Y-M-D
        $donation = Donation::whereDate('created_at', '>=', $request->dateMin)
                            ->whereDate('created_at', '<=', $request->dateMax)
                            ->get();
        $investment = Investment::whereDate('created_at', '>=', $request->dateMin)
                                ->whereDate('created_at', '<=', $request->dateMax)
                                ->get();
        return response()->json([
            'donation'=>$donation,
            'investment'=>$investment,
        ], 201);
    }

    public function userTransaction(Request $request)
    {
        $user = DB::table('users')->where('cpf', $request->cpf)->first();
        $donation = Donation::where('user_id',$user->id)->get();
        $investment = Investment::where('user_id',$user->id)->get();
        return response()->json([
            'user'=>$user,
            'donation'=>$donation,
            'investment'=>$investment,
        ], 201);
    }
}
