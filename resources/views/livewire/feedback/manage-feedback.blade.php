<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:800px; margin:0 auto;">

        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back to Home
        </a>

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div>
                    <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">💬 User Feedback</h1>
                    <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">{{ $unreadCount }} unread / {{ $feedbacks->total() }} total</p>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" wire:click="$set('filter', '')" style="background:{{ $filter === '' ? 'rgba(255,255,255,.25)' : 'rgba(255,255,255,.1)' }}; border:none; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">All</button>
                    <button type="button" wire:click="$set('filter', 'unread')" style="background:{{ $filter === 'unread' ? 'rgba(255,255,255,.25)' : 'rgba(255,255,255,.1)' }}; border:none; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">Unread</button>
                    <button type="button" wire:click="markAllRead" style="background:rgba(255,255,255,.15); border:none; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">✓ Mark All Read</button>
                </div>
            </div>

            <div style="padding:16px;">
                @forelse($feedbacks as $fb)
                <div style="padding:16px; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:8px; {{ !$fb->is_read ? 'background:#f0fdf4; border-color:var(--muk-green);' : 'background:#fff;' }}">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px; flex-wrap:wrap;">
                                <span style="font-weight:700; font-size:14px; color:#333;">{{ $fb->user->name }}</span>
                                <span style="font-size:11px; color:#888;">{{ $fb->user->email }}</span>
                                <span style="font-size:10px; padding:2px 10px; border-radius:999px; font-weight:700;
                                    {{ $fb->type === 'bug_report' ? 'background:#fef2f2; color:var(--muk-red);' : '' }}
                                    {{ $fb->type === 'suggestion' ? 'background:#fffbeb; color:#92400e;' : '' }}
                                    {{ $fb->type === 'general' ? 'background:#f0fdf4; color:var(--muk-green);' : '' }}
                                ">
                                    @if($fb->type === 'bug_report') 🐛 Bug Report
                                    @elseif($fb->type === 'suggestion') 💡 Suggestion
                                    @else 💬 General
                                    @endif
                                </span>
                                @if(!$fb->is_read)
                                <span style="width:8px; height:8px; border-radius:50%; background:var(--muk-green); display:inline-block;"></span>
                                @endif
                            </div>
                            <div style="font-size:14px; color:#333; line-height:1.6; white-space:pre-wrap;">{{ $fb->message }}</div>
                            <div style="font-size:11px; color:#aaa; margin-top:8px;">{{ $fb->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        @if(!$fb->is_read)
                        <button type="button" wire:click="markAsRead({{ $fb->id }})" style="background:#fff; border:1px solid #e5e7eb; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; color:#888; cursor:pointer; white-space:nowrap; flex-shrink:0;">✓ Mark Read</button>
                        @endif
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:60px 20px;">
                    <div style="font-size:48px; margin-bottom:12px;">📭</div>
                    <div style="font-size:18px; font-weight:700; color:#888;">No feedback yet</div>
                    <div style="font-size:13px; color:#aaa; margin-top:4px;">Feedback from users will appear here.</div>
                </div>
                @endforelse

                <div style="margin-top:16px;">
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
