<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Displays a listing of the users with search, filter, sort, and pagination.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->paginate(7)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Displays the create user form.
     * 
     * @return  Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Displays the edit user form for a given user.
     *
     * @param  App\Models\User  $user
     * @return  Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Delete a user.
     *
     * @param  App\Models\User  $user
     * @return  Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', __('User deleted successfully.'));
    }

    
    /**
     * Creates a new user based on the given request data.
     *
     * @param  Illuminate\Http\Request  $request
     * @return  Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:0,1',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', __('User created successfully.'));
    }

    /**
     * Updates an existing user based on the given request data.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\User  $user
     * @return  Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:0,1',
        ]);
        $user->update($validatedData);
        return redirect()->route('admin.users.index')->with('success', __('User updated successfully.'));
    }

}
