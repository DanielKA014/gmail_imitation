<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy(Request $request, string $id)
    {
        $user = auth()->user();

        if ($user){
            User::destroy($id);
            return redirect()->back()->with("success", "User dengan id {$id} berhasil dihapus.");
        } else{
            return redirect()->back()->withErrors(["authorization" => "authorization failed."]);
        }
    }
}



