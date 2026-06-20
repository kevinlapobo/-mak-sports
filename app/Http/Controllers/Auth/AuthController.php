<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        $teams = \App\Models\Team::where('is_active', true)->orderBy('name')->get();
        return view('auth.register', compact('teams'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@/', function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '.com')) {
                    $fail('The email must end with .com');
                }
            }],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:student,player,coach'],
            'phone' => ['nullable', 'string', 'max:20'],
            'team_id' => ['nullable', 'exists:teams,id'],
            'student_number' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $status = in_array($validated['role'], ['player', 'coach']) ? 'pending' : 'approved';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'full_name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'team_id' => $validated['team_id'] ?? null,
            'student_number' => $validated['student_number'] ?? null,
            'photo' => $photoPath,
            'status' => $status,
        ]);

        Auth::login($user);

        session()->flash('registration_success', true);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = auth()->user();

        $data = ['user' => $user];

        if ($user->role === 'coach') {
            $data['recentCompetitions'] = \App\Models\Competition::with('sport')
                ->where('is_active', true)
                ->orderByDesc('start_date')
                ->get();
        }

        return view('auth.dashboard', $data);
    }

    public function redirectToGoogle()
    {
        if (!env('GOOGLE_CLIENT_ID') || !env('GOOGLE_CLIENT_SECRET')) {
            return redirect()->route('login')->withErrors(['email' => 'Google login is not configured. Please contact support.']);
        }
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
            } else {
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::login($existingUser);
                } else {
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'role' => 'student',
                        'full_name' => $googleUser->name,
                        'password' => Hash::make(Str::random(32)),
                    ]);
                    Auth::login($newUser);
                }
            }

            $request = request();
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return redirect()->route('login')->withErrors(['email' => 'Google login failed: ' . $e->getMessage()]);
            }
            return redirect()->route('login')->withErrors(['email' => 'Google login failed. Please try again.']);
        }
    }
}
