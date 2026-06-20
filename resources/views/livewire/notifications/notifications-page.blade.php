<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:720px; margin:0 auto; padding:0 16px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
            <div>
                <h1 style="font-size:22px; font-weight:800; color:var(--muk-green-dark); margin:0 0 4px;">Notifications</h1>
                <p style="font-size:14px; color:#9a9a9a; margin:0;">Stay updated with the latest fixtures and results</p>
            </div>
            <div style="display:flex; gap:8px;">
                <select wire:model.live="filter" style="padding:8px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                    <option value="all">All</option>
                    <option value="unread">Unread</option>
                </select>
<button wire:click="markAllRead" wire:loading.attr="disabled" style="padding:8px 14px; background:var(--muk-green); color:#fff; border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
    <span wire:loading.remove wire:target="markAllRead">Mark All Read</span>
    <span wire:loading wire:target="markAllRead" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
<button wire:click="deleteAll" wire:loading.attr="disabled" style="padding:8px 14px; background:#fee2e2; color:var(--muk-red); border:none; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;" onclick="return confirm('Delete all notifications?')">
    <span wire:loading.remove wire:target="deleteAll">Clear All</span>
    <span wire:loading wire:target="deleteAll" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid var(--muk-red);border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
            </div>
        </div>

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">
            @forelse($notifications as $notification)
                @php $data = $notification->data; @endphp
                <div style="padding:16px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:flex-start; gap:14px; {{ $notification->read_at ? '' : 'background:#f0fdf4;' }} cursor:pointer;" wire:click="markAsRead('{{ $notification->id }}')">
                    <div style="flex-shrink:0; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:16px; {{ $data['type'] === 'new_result' ? 'background:#fef3c7;' : 'background:#e8f5ee;' }}">
                        {{ $data['type'] === 'new_result' ? '⚽' : '📅' }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:14px; font-weight:700; color:#111; margin-bottom:2px;">{{ $data['title'] }}</div>
                        <div style="font-size:13px; color:#555; line-height:1.4;">{{ $data['message'] }}</div>
                        @if(isset($data['competition']))
                            <div style="font-size:11px; color:#888; margin-top:2px;">{{ $data['competition'] }}</div>
                        @endif
                        <div style="font-size:11px; color:#aaa; margin-top:4px;">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                    <div style="display:flex; gap:4px; flex-shrink:0;">
                        <a href="{{ route('match.detail', $data['match_id']) }}" style="padding:6px 12px; background:var(--muk-green); color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:700; text-decoration:none; white-space:nowrap;">View</a>
                        <button wire:click="deleteNotification('{{ $notification->id }}')" wire:loading.attr="disabled" style="padding:6px 8px; background:transparent; border:none; color:#ccc; cursor:pointer; font-size:14px; display:inline-flex; align-items:center; justify-content:center;" title="Delete">
    <span wire:loading.remove wire:target="deleteNotification('{{ $notification->id }}')">✕</span>
    <span wire:loading wire:target="deleteNotification('{{ $notification->id }}')" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid #ccc;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
                    </div>
                </div>
            @empty
                <div style="padding:48px; text-align:center;">
                    <div style="font-size:48px; margin-bottom:12px;">🔔</div>
                    <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Notifications</div>
                    <div style="font-size:13px; color:#888;">You'll see new fixtures and results here.</div>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div style="margin-top:16px;">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
</div>
