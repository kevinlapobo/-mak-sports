<x-layouts.auth :title="'Dashboard'" :heading="'My Dashboard'">
    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div class="mak-green rounded-xl p-6 text-white">
            <h3 class="text-xl font-bold">Welcome back, {{ auth()->user()->name }}!</h3>
            <p class="mt-1 text-green-100">Role: <span class="font-semibold capitalize">{{ auth()->user()->role }}</span></p>
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
        @if(auth()->user()->isStudent())
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
        @elseif(auth()->user()->isPlayer())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Player Dashboard</h4>
                <div class="space-y-3">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="font-semibold text-[#28A745]">My Stats</div>
                        <div class="text-sm text-gray-600">Your performance statistics will appear here once linked to a player profile</div>
                    </div>
                    <a href="{{ route('teams') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">My Team</div>
                        <div class="text-sm text-gray-600">View your team's information</div>
                    </a>
                </div>
            </div>
        @elseif(auth()->user()->isCoach())
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Coach Dashboard</h4>
                <div class="space-y-3">
                    <a href="{{ route('standings') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Competition Standings</div>
                        <div class="text-sm text-gray-600">Monitor your team's position in the league</div>
                    </a>
                    <a href="{{ route('fixtures') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Upcoming Fixtures</div>
                        <div class="text-sm text-gray-600">Plan for upcoming matches</div>
                    </a>
                    <a href="{{ route('teams') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="font-semibold text-[#28A745]">Team Management</div>
                        <div class="text-sm text-gray-600">View and manage your team roster</div>
                    </a>
                </div>
            </div>

            {{-- Recent Competitions (Coach Only) --}}
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
