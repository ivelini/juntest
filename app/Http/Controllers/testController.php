<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class testController extends Controller
{
    public function test(Request $request)
    {
        if(Auth::attempt(['email' => 'test@test.ru', 'password' => 'password'])) {
            $user = User::query()->where('email', 'test@test.ru')->first();
            $expiresAt = Carbon::now()->addMinute(5);
            dd($user->createToken('test', ['*'], $expiresAt)->plainTextToken);
        }
    }
}
