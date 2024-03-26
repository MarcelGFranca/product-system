<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\User;


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
	 * Display all users
	 */
	public function index(Request $request): View
	{
		$users = User::all();
		return view('profile.index', [
			'users' => $users
		]);
	}

	/**
	 * the user's profile information.
	 */
	public function show($id): View
	{
		$user = User::findOrFail($id);
		return view('profile.show', [
			'user' => $user
		]);
	}

	/**
	 * Update the user's profile information.
	 */
	public function update(ProfileUpdateRequest $request): RedirectResponse
	{
		$request->user()->fill($request->validated());

		if ($request->user()->isDirty('email')) {
			$request->user()->email_verified_at = null;
		}

		$request->user()->save();

		return Redirect::route('profile.edit')->with('status', 'profile-updated');
	}

	/**
	 * Delete the user's account.
	 */
	public function destroy(Request $request): RedirectResponse
	{
		$request->validateWithBag('userDeletion', []);

		$user = $request->user();

		Auth::logout();

		$user->delete();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return Redirect::to('/');
	}
}
