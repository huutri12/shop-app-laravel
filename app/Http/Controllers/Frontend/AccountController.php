<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;

class AccountController extends Controller
{
    // GET /account/update
    public function edit()
    {
        $user = Auth::user();

        $countries = Country::all();
        return view('frontend.account.update', compact('user', 'countries'));
    }

    // POST /account/update
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        unset($data['email']);


        if ($request->hasFile('avatar')) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }


        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        unset($data['password']);

        $user->fill($data)->save();

        return back()->with('success', 'Cập nhật tài khoản thành công!');
    }
}
