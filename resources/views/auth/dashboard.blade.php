<x-layouts.auth :title="'Dashboard'" :heading="'My Dashboard'">
    @php $user = auth()->user(); $photoUrl = $user->photo ? Storage::url($user->photo) : null; @endphp

    {{-- SUCCESS MODAL after registration --}}
    @if(session('registration_success'))
    <div id="successModal" style="position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.5); backdrop-filter:blur(4px); padding:20px;">
        <div style="background:#fff; border-radius:20px; max-width:420px; width:100%; padding:32px 24px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,.3); animation:popIn .3s ease-out;">
            <div style="width:64px; height:64px; border-radius:50%; background:#f0fdf4; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <span style="font-size:32px;">✅</span>
            </div>
            <h2 style="font-size:20px; font-weight:900; color:#111; margin-bottom:4px;">Account Created!</h2>
            <p style="font-size:14px; color:#6b7280; line-height:1.6; margin-bottom:16px;">
                @if($user->isPending())
                Your account has been created and is awaiting approval by an Administrator . You'll be notified once approved.
                @else
                Welcome to Makerere Sports! Start exploring live scores, fixtures, and more.
                @endif
            </p>
            <button onclick="document.getElementById('successModal').remove()" style="background:var(--muk-green, #28A745); color:#fff; border:none; padding:12px 28px; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; transition:background .15s;" onmouseover="this.style.background='#1e7e34'" onmouseout="this.style.background='#28A745'">Got it!</button>
        </div>
    </div>
    <style>
        @keyframes popIn { from { transform:scale(.9); opacity:0; } to { transform:scale(1); opacity:1; } }
    </style>
    @endif

    {{-- PENDING WARNING BANNER --}}
    @if($user->isPending())
    <div style="background:#fef3c7; border:1px solid #f59e0b; border-radius:12px; padding:14px 16px; margin-bottom:16px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">⏳</span>
        <div style="font-size:13px; color:#92400e; line-height:1.5;">
            <strong>Account Pending Approval</strong> — Your account is awaiting approval by an administrator. Some features may be limited until approved.
        </div>
    </div>
    @endif

    <div class="space-y-6">
        {{-- Welcome Banner with Photo --}}
        <div class="mak-green rounded-xl p-6 text-white" style="display:flex; align-items:center; gap:16px;">
            <div style="width:56px; height:56px; border-radius:50%; background:var(--muk-gold); color:var(--muk-black); display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:900; flex-shrink:0; border:3px solid rgba(255,255,255,.3); overflow:hidden;">
                @if($photoUrl)
                <img src="{{ $photoUrl }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold">Welcome back, {{ $user->name }}!</h3>
                <p class="mt-1 text-green-100">Role: <span class="font-semibold capitalize">{{ str_replace('_', ' ', $user->role) }}</span></p>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('live') }}" class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-[#28A745]">LIVE</div>
                <div class="text-sm text-gray-500">Live Scores</div>
            </a>
            <a href="{{ route('results') }}" class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-[#28A745]">FT</div>
                <div class="text-sm text-gray-500">Results</div>
            </a>
            <a href="{{ route('standings') }}" class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-[#28A745]">📊</div>
                <div class="text-sm text-gray-500">Standings</div>
            </a>
            <a href="{{ route('fixtures') }}" class="bg-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                <div class="text-2xl font-bold text-[#28A745]">📅</div>
                <div class="text-sm text-gray-500">Fixtures</div>
            </a>
        </div>

        {{-- Role-Specific Content --}}
        @if($user->isStudent())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Your Sports Overview</h4>
                <div class="space-y-3">
                    <a href="{{ route('standings') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">League Standings</div>
                        <div class="text-sm text-gray-600">Check current standings across all competitions</div>
                    </a>
                    <a href="{{ route('fixtures') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Upcoming Matches</div>
                        <div class="text-sm text-gray-600">See what matches are coming up</div>
                    </a>
                    <a href="{{ route('results') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Recent Results</div>
                        <div class="text-sm text-gray-600">Catch up on the latest results</div>
                    </a>
                </div>
            </div>
        @elseif($user->isPlayer())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:48px; height:48px; border-radius:50%; background:var(--muk-green); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; flex-shrink:0; overflow:hidden;">
                        @if($photoUrl)
                        <img src="{{ $photoUrl }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Player Dashboard</h4>
                        <p class="text-sm text-gray-500">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('player.profile') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">My Profile</div>
                        <div class="text-sm text-gray-600">View and edit your player profile</div>
                    </a>
                    <a href="{{ route('teams') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">My Team</div>
                        <div class="text-sm text-gray-600">View your team's information</div>
                    </a>
                </div>
            </div>
        @elseif($user->isCoach())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:48px; height:48px; border-radius:50%; background:var(--muk-green); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; flex-shrink:0; overflow:hidden;">
                        @if($photoUrl)
                        <img src="{{ $photoUrl }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Coach Dashboard</h4>
                        <p class="text-sm text-gray-500">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('standings') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Competition Standings</div>
                        <div class="text-sm text-gray-600">Monitor your team's position in the league</div>
                    </a>
                    <a href="{{ route('fixtures') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Upcoming Fixtures</div>
                        <div class="text-sm text-gray-600">Plan for upcoming matches</div>
                    </a>
                    <a href="{{ route('coach.my-teams') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">My Teams</div>
                        <div class="text-sm text-gray-600">Register and manage your teams</div>
                    </a>
                    <a href="{{ route('coach.profile') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Coach Profile</div>
                        <div class="text-sm text-gray-600">Update your coaching profile</div>
                    </a>
                    <a href="{{ route('coach.stats') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">My Stats</div>
                        <div class="text-sm text-gray-600">View your coaching statistics</div>
                    </a>
                </div>
            </div>

            @if(isset($recentCompetitions) && $recentCompetitions->count() > 0)
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Recent & Active Competitions</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Competition</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Sport</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Season</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentCompetitions as $comp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-3 text-sm font-semibold text-gray-900">{{ $comp->name }}</td>
                                <td class="px-3 py-3 text-sm text-gray-600">{{ $comp->sport->name ?? 'N/A' }}</td>
                                <td class="px-3 py-3 text-sm text-gray-600">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $comp->type === 'league' ? 'bg-blue-100 text-blue-800' : ($comp->type === 'cup' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800') }}">
                                        {{ ucfirst($comp->type) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-600">{{ $comp->season }}</td>
                                <td class="px-3 py-3 text-sm">
                                    @if($comp->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @elseif($user->isFacilityManager())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div style="width:48px; height:48px; border-radius:50%; background:var(--muk-gold); color:var(--muk-black); display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; flex-shrink:0; overflow:hidden;">
                        @if($photoUrl)
                        <img src="{{ $photoUrl }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Facility Manager Dashboard</h4>
                        <p class="text-sm text-gray-500">Full system access</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('facility.approvals') }}" class="block p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors" style="border:1px solid #f59e0b;">
                        <div class="font-semibold text-amber-600">⏳ Pending Approvals</div>
                        <div class="text-sm text-gray-600">Approve or reject new player and coach registrations</div>
                    </a>
                    <a href="{{ route('standings') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Standings</div>
                        <div class="text-sm text-gray-600">Manage competition standings</div>
                    </a>
                    <a href="{{ route('fixtures') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Fixtures</div>
                        <div class="text-sm text-gray-600">View and manage fixtures</div>
                    </a>
                    <a href="{{ route('venues.index') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">🏟 Venues</div>
                        <div class="text-sm text-gray-600">Manage venue bookings</div>
                    </a>
                    <a href="{{ route('teams') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Teams</div>
                        <div class="text-sm text-gray-600">View all teams</div>
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Follow Your Favorite Sports</h4>
                <p class="text-gray-600">Browse all the latest scores, fixtures, and standings.</p>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="{{ route('live') }}" class="text-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-bold text-[#28A745]">Live Scores</div>
                    </a>
                    <a href="{{ route('teams') }}" class="text-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-bold text-[#28A745]">Teams</div>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.auth>