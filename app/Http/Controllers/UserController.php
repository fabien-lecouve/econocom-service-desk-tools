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

        $users = User::select('id', 'lastname', 'firstname', 'email')
            ->with([
                'memberships.role',
                'memberships.project'
            ])
            ->orderBy('lastname')
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $projects = Project::select('id', 'label')->get();
        $roles = Role::select('id', 'label')->get();

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
        $this->authorize('create', User::class);

        $validated = $request->validated();

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->is_admin = $validated['is_admin'] ?? false;
            $user->is_knowledge_manager = $validated['is_knowledge_manager'] ?? false;
            $user->save();

            foreach ($validated['memberships'] as $membership) {
                $user->memberships()->create([
                    'project_id' => $membership['project_id'],
                    'role_id' => $membership['role_id'],
                ]);
            }
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'L\'utilisateur a bien été créé.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load(['memberships.project', 'memberships.role']);

        $projects = Project::select('id', 'label')->get();
        $roles = Role::select('id', 'label')->get();

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
        $this->authorize('update', $user);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $user) {
            $user->firstname = $validated['firstname'];
            $user->lastname = $validated['lastname'];
            $user->email = $validated['email'];
            $user->is_admin = $validated['is_admin'] ?? false;
            $user->is_knowledge_manager = $validated['is_knowledge_manager'] ?? false;

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            $user->memberships()->forceDelete();

            foreach ($validated['memberships'] as $membership) {
                $user->memberships()->create([
                    'project_id' => $membership['project_id'],
                    'role_id' => $membership['role_id'],
                ]);
            }
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'L\'utilisateur a bien été modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'L\'utilisateur a bien été supprimé.');
    }
}
