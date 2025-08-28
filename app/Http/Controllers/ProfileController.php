<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        die('23333');
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {

    //     // $user = $request->user();


    //     // $validatedData = $request->validate([
    //     //     'ten' => 'required|string|max:255',
    //     //     // 'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    //     //     'sdt' => 'required|digits_between:10,11',
    //     //     'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     // ]);

    //     die('123');
    //     // Nếu có file ảnh được tải lên
    //     if ($request->hasFile('anh')) {
    //         // Lưu file vào thư mục 'uploads/avatars'
    //         $filePath = $request->file('anh')->store('Anh-Dai-Dien', 'public');

    //         // Gán đường dẫn vào mảng dữ liệu đã xác thực
    //         $validatedData['anh'] = 'storage/' . $filePath;
    //     }

    //     // Kiểm tra nếu email thay đổi
    //     if ($validatedData['email'] !== $user->email) {
    //         $validatedData['email_verified_at'] = null;
    //     }

    //     // Cập nhật thông tin vào database
    //     $check =  DB::table('users')->where('id', $user->id)->update($validatedData);
    //     dd($check);

    //     // Chuyển hướng kèm thông báo thành công
    //     return redirect()->back()->with('status', 'profile-updated');
    // }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
