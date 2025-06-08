<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Assuming User model is used

class UserController extends Controller
{
    // index
    public function index(Request $request)
    {
        // get all users with pagination
        $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%')
                  ->orWhere('email', 'like', '%' . $name . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    // create
    public function create()
    {
        // return to view pages.users.create
        return view('pages.users.create');
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:50',
        ]);

        // create a new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // show
    public function show($id)
    {
        // Logic to retrieve and return a specific user by ID
        return response()->json(['message' => 'User details for ID: ' . $id]);
    }

    // edit
    public function edit($id)
    {
        // Logic to retrieve the user for editing
        // Return to view pages.users.edit with user data
        $user = User::findOrFail($id); // Assuming User model is used
        return view('pages.users.edit', compact('user'));
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|max:50',
        ]);

        // update the requested user
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        // if password is not empty, update it
        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        // Logic to delete a user by ID
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
