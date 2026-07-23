<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Project;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('memberships.role')
            ->with('memberships.project')
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $roles = Role::all();

        return view('users.create', [
            'projects' => $projects,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => $validated['is_admin'] ?? false,
                'is_knowledge_manager' => $validated['is_knowledge_manager'] ?? false,
            ]);

            foreach ($validated['memberships'] as $membership) {
                $user->memberships()->create([
                    'project_id' => $membership['project_id'],
                    'role_id' => $membership['role_id'],
                ]);
            }
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['memberships.project', 'memberships.role']);

        $projects = Project::all();
        $roles = Role::all();

        return view('users.edit', [
            'user' => $user,
            'projects' => $projects,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $user) {
            $userData = [
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'is_admin' => $validated['is_admin'] ?? false,
                'is_knowledge_manager' => $validated['is_knowledge_manager'] ?? false,
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            $user->memberships()->delete();

            foreach ($validated['memberships'] as $membership) {
                $user->memberships()->create([
                    'project_id' => $membership['project_id'],
                    'role_id' => $membership['role_id'],
                ]);
            }
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}
