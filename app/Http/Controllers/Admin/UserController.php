<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * PROFILE của admin (chính tài khoản đang đăng nhập)
     */
    public function profile()
    {
        $user = Auth::user();
        $countries = DB::table('countries')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.user.profile', compact('user', 'countries'));
    }

    /**
     * Cập nhật PROFILE của admin đang đăng nhập
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user(); // hoặc User::findOrFail(Auth::id());

        $data = $request->only(['name', 'email']);
        $file = $request->file('avatar');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($file) {
            $data['avatar'] = $file->getClientOriginalName();
        }

        if ($user->update($data)) {
            if ($file) {
                $file->move('upload/user/avatar', $file->getClientOriginalName());
            }

            return back()->with('success', 'Update profile success.');
        }

        return back()->withErrors('Update profile error.');
    }

    /**
     * LIST USER cho admin
     */
    public function index()
    {
        $users = User::orderBy('id')->paginate(15);

        return view('admin.user.index', compact('users'));
    }

    /**
     * FORM EDIT một user bất kỳ (admin dùng)
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    /**
     * UPDATE một user bất kỳ (admin dùng)
     */
    public function updateUser(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'level' => 'required|in:0,1',
        ]);

        $data = $request->only(['name', 'email', 'level']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật user thành công.');
    }

    /**
     * DELETE user
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return back()->with('success', 'Xóa user thành công.');
    }
}
