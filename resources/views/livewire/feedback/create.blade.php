<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:600px; margin:0 auto;">

        <a href="{{ url()->previous() }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back
        </a>

        @if(session('feedback_sent'))
        <div style="background:#f0fdf4; border:2px solid var(--muk-green); border-radius:16px; padding:40px 24px; text-align:center;">
            <div style="font-size:48px; margin-bottom:12px;">🙏</div>
            <div style="font-size:22px; font-weight:900; color:var(--muk-green); margin-bottom:8px;">Thank You!</div>
            <div style="font-size:14px; color:#555; line-height:1.6; max-width:400px; margin:0 auto;">
                Your feedback has been received. We appreciate you taking the time to help us improve the Makerere Sports platform.
            </div>
            <div style="margin-top:24px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; background:var(--muk-green); color:#fff; padding:10px 20px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">🏠 Back to Home</a>
                <button type="button" onclick="location.reload()" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 20px; border-radius:8px; font-size:14px; font-weight:600; color:#333; cursor:pointer;">✏️ Submit Another</button>
            </div>
        </div>
        @else
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px 24px;">
                <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">💬 Send Feedback</h1>
                <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Help us improve the Makerere Sports platform</p>
            </div>

            <form wire:submit="submit" style="padding:24px;">
                <div style="margin-bottom:20px;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:6px;">Type <span style="color:var(--muk-red);">*</span></label>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <label style="flex:1; min-width:120px; padding:12px 16px; border:2px solid {{ $type === 'general' ? 'var(--muk-green)' : '#e5e7eb' }}; border-radius:10px; cursor:pointer; text-align:center; {{ $type === 'general' ? 'background:#f0fdf4;' : 'background:#fff;' }}">
                            <input type="radio" wire:model.live="type" value="general" style="accent-color:var(--muk-green);">
                            <div style="font-size:13px; font-weight:700; margin-top:4px;">💬 General</div>
                        </label>
                        <label style="flex:1; min-width:120px; padding:12px 16px; border:2px solid {{ $type === 'suggestion' ? 'var(--muk-gold)' : '#e5e7eb' }}; border-radius:10px; cursor:pointer; text-align:center; {{ $type === 'suggestion' ? 'background:#fffbeb;' : 'background:#fff;' }}">
                            <input type="radio" wire:model.live="type" value="suggestion" style="accent-color:var(--muk-gold);">
                            <div style="font-size:13px; font-weight:700; margin-top:4px;">💡 Suggestion</div>
                        </label>
                        <label style="flex:1; min-width:120px; padding:12px 16px; border:2px solid {{ $type === 'bug_report' ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:10px; cursor:pointer; text-align:center; {{ $type === 'bug_report' ? 'background:#fef2f2;' : 'background:#fff;' }}">
                            <input type="radio" wire:model.live="type" value="bug_report" style="accent-color:var(--muk-red);">
                            <div style="font-size:13px; font-weight:700; margin-top:4px;">🐛 Bug Report</div>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label for="message" style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:6px;">Your Message <span style="color:var(--muk-red);">*</span></label>
                    <textarea id="message" wire:model="message" rows="5" placeholder="Tell us what's on your mind..." required style="width:100%; padding:12px; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; line-height:1.6; resize:vertical; font-family:inherit;"></textarea>
                    @error('message') <span style="font-size:12px; color:var(--muk-red); margin-top:4px; display:block;">{{ $message }}</span> @enderror
                    <div style="font-size:11px; color:#aaa; margin-top:4px; text-align:right;">{{ strlen($message) }}/2000</div>
                </div>

                <button type="submit" wire:loading.attr="disabled" style="width:100%; padding:14px; background:var(--muk-green); color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                    <span wire:loading.remove wire:target="submit">📤 Submit Feedback</span>
                    <span wire:loading wire:target="submit" style="display:flex; align-items:center; gap:6px;"><span style="width:16px;height:16px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Sending...</span>
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
</div>
