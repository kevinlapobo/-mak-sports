<x-layouts.auth :title="'Register'" :heading="'Join Makerere Sports'" :subheading="'Create your account to access personalized sports content'">
    <form class="space-y-5" method="POST" action="{{ route('register.post') }}">
        @csrf

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
            <input id="name" name="name" type="text" required
                class="mt-1 appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent"
                value="{{ old('name') }}">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">Email address</label>
            <input id="email" name="email" type="email" autocomplete="email" required
                class="mt-1 appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent"
                value="{{ old('email') }}">
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700">Phone (optional)</label>
            <input id="phone" name="phone" type="tel"
                class="mt-1 appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent"
                value="{{ old('phone') }}">
        </div>

        <div>
            <label for="role" class="block text-sm font-semibold text-gray-700">I am a <span class="text-red-500">*</span></label>
            <select id="role" name="role" required
                class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent"
                onchange="toggleRoleFields()">
                <option value="">Select your role...</option>
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student - View results, standings & upcoming matches</option>
                <option value="player" {{ old('role') === 'player' ? 'selected' : '' }}>Player - Track your stats & performance</option>
                <option value="coach" {{ old('role') === 'coach' ? 'selected' : '' }}>Coach - Manage team & view competitions</option>
                <option value="spectator" {{ old('role') === 'spectator' ? 'selected' : '' }}>Fan/Spectator - Follow your favorite teams</option>
            </select>
        </div>

        <div id="teamField" class="hidden">
            <label for="team_id" class="block text-sm font-semibold text-gray-700">Your Team <span class="text-red-500">*</span></label>
            <select id="team_id" name="team_id"
                class="mt-1 block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent">
                <option value="">Select your team...</option>
                @if(isset($teams))
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->sport->name ?? 'N/A' }})</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
            <div class="relative mt-1">
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent pr-10">
                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="h-5 w-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="h-5 w-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
            <div class="relative mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                    class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#28A745] focus:border-transparent pr-10">
                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="h-5 w-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="h-5 w-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white mak-green hover:bg-[#1e7e34] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#28A745] transition-colors">
                Create Account
            </button>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('auth.google') }}"
            class="w-full flex items-center justify-center gap-3 py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#28A745] transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </a>
    </div>

    <div class="mt-6 text-center">
        <span class="text-sm text-gray-600">Already have an account?</span>
        <a href="{{ route('login') }}" class="ml-1 font-semibold text-[#28A745] hover:text-[#1e7e34]">
            Sign in here
        </a>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            const teamField = document.getElementById('teamField');
            if (role === 'player' || role === 'coach') {
                teamField.classList.remove('hidden');
            } else {
                teamField.classList.add('hidden');
            }
        }
        document.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>
</x-layouts.auth>
