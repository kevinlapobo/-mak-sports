<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:900px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #d97706, #f59e0b); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">⏳ Pending Approvals</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Approve or reject coach and player registrations</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <div style="padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap; border-bottom:1px solid #e5e7eb;">
                <input type="text" wire:model.live.debounce="search" placeholder="Search name or email..." style="flex:1; min-width:200px; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">

                <select wire:model.live="roleFilter" style="padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                    <option value="">All Roles</option>
                    <option value="coach">Coach</option>
                    <option value="player">Player</option>
                </select>

                <select wire:model.live="statusFilter" style="padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="">All Status</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="table-wrap" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:500px;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="padding:12px 16px; text-align:left; font-weight:700; color:#333;">Name</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700; color:#333;">Email</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700; color:#333;">Role</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700; color:#333;">Status</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700; color:#333;">Registered</th>
                            <th style="padding:12px 16px; text-align:right; font-weight:700; color:#333;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:12px 16px; font-weight:600;">{{ $user->name }}</td>
                            <td style="padding:12px 16px; color:#888;">{{ $user->email }}</td>
                            <td style="padding:12px 16px;">
                                <span style="background:{{ $user->role === 'coach' ? '#f0fdf4' : '#eff6ff' }}; color:{{ $user->role === 'coach' ? 'var(--muk-green)' : '#2563eb' }}; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; text-transform:capitalize;">{{ $user->role }}</span>
                            </td>
                            <td style="padding:12px 16px;">
                                <span style="background:{{ $user->status === 'pending' ? '#fef3c7' : ($user->status === 'approved' ? '#f0fdf4' : '#fef2f2') }}; color:{{ $user->status === 'pending' ? '#d97706' : ($user->status === 'approved' ? 'var(--muk-green)' : '#ef4444') }}; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600; text-transform:capitalize;">{{ $user->status }}</span>
                            </td>
                            <td style="padding:12px 16px; color:#888; font-size:12px;">{{ $user->created_at->format('d M Y') }}</td>
                            <td style="padding:12px 16px; text-align:right; white-space:nowrap;">
                                @if($user->status === 'pending')
<button wire:click="approve({{ $user->id }})" wire:loading.attr="disabled" style="background:var(--muk-green); color:#fff; border:none; padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; margin-right:4px; display:inline-flex; align-items:center; gap:4px;">
    <span wire:loading.remove wire:target="approve({{ $user->id }})">Approve</span>
    <span wire:loading wire:target="approve({{ $user->id }})" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
<button wire:click="reject({{ $user->id }})" wire:loading.attr="disabled" style="background:#fee2e2; color:var(--muk-red); border:none; padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
    <span wire:loading.remove wire:target="reject({{ $user->id }})">Reject</span>
    <span wire:loading wire:target="reject({{ $user->id }})" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid var(--muk-red);border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
                                @elseif($user->status === 'approved')
                                <span style="font-size:11px; color:var(--muk-green); font-weight:600;">✓ Approved</span>
                                @else
                                <span style="font-size:11px; color:var(--muk-red); font-weight:600;">✕ Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:40px; text-align:center; color:#888;">
                                <div style="font-size:36px; margin-bottom:8px;">✅</div>
                                <div style="font-size:14px;">No {{ $statusFilter === 'pending' ? 'pending' : '' }} registrations found.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
