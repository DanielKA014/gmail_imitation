<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("email.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '<>', auth()->id())->get();
        return view("email.create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "to"=>["required"],
            "subject"=>["required"],
            "body"=>["required"],
            "file"=>["nullable", "file"]]
        );

        Email::create($validated);
        return redirect()->route("email.index")->with("success","Sudah Terkirim");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Email::destroy($id);
        return redirect()->back()->with("success","Email berhasil dihapus");
    }
}
