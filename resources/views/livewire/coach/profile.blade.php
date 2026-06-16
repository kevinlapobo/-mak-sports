<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:650px; margin:0 auto; padding:0 16px;">

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); padding:24px; text-align:center;">
                <div style="width:72px; height:72px; border-radius:50%; background:rgba(255,255,255,.2); margin:0 auto 12px; display:flex; align-items:center; justify-content:center; overflow:hidden; border:3px solid rgba(255,255,255,.3);">
                    @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                    <span style="font-size:28px; font-weight:900; color:#fff;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <h1 style="font-size:20px; font-weight:900; color:#fff; margin:0;">👤 Coach Profile</h1>
                <p style="color:rgba(255,255,255,.6); font-size:12px; margin-top:4px;">{{ $user->email }}</p>
            </div>

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:16px 20px; margin:16px; border-radius:0 8px 8px 0;">
                <div style="font-size:14px; font-weight:700; color:var(--muk-red);">⚠️ Please fix the following:</div>
                <ul style="margin:8px 0 0 20px; font-size:13px; color:#333;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form wire:submit="updateProfile" style="padding:24px;">
                {{-- Photo Upload --}}
                <div style="margin-bottom:20px; text-align:center;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:8px;">Profile Photo</label>
                    <div style="display:flex; align-items:center; justify-content:center; gap:12px; flex-wrap:wrap;">
                        <div style="width:56px; height:56px; border-radius:50%; background:#f0f0f0; display:flex; align-items:center; justify-content:center; overflow:hidden; border:2px solid #e5e7eb;">
                            @if($newPhoto)
                            <img src="{{ $newPhoto->temporaryUrl() }}" style="width:100%;height:100%;object-fit:cover;">
                            @elseif($user->photo)
                            <img src="{{ Storage::url($user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                            <span style="font-size:18px; color:#888;">📷</span>
                            @endif
                        </div>
                        <label style="cursor:pointer; background:#fff; border:1px solid #e5e7eb; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:600; color:#333; transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                            Change Photo
                            <input type="file" wire:model="newPhoto" accept="image/jpeg,image/png" class="hidden" style="display:none;">
                        </label>
                    </div>
                    @error('newPhoto') <span style="font-size:11px; color:var(--muk-red); display:block; margin-top:4px;">{{ $message }}</span> @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Full Name <span style="color:var(--muk-red);">*</span></label>
                        <input type="text" wire:model="full_name" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Phone</label>
                        <input type="text" wire:model="phone" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:20px 0;">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Specialization</label>
                        <input type="text" wire:model="specialization" placeholder="e.g. Football, Basketball" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Years of Experience</label>
                        <input type="number" wire:model="experience_years" min="0" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Qualifications</label>
                    <textarea wire:model="qualification" rows="3" placeholder="Certifications, degrees, etc." style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; resize:vertical;"></textarea>
                </div>

                <button type="submit" wire:loading.attr="disabled" style="width:100%; padding:14px; background:var(--muk-red); color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; transition:background .15s; display:flex; align-items:center; justify-content:center; gap:8px;" onmouseover="this.style.background='#990000'" onmouseout="this.style.background='var(--muk-red)'">
                    <span wire:loading.remove wire:target="updateProfile">Update Profile</span>
                    <span wire:loading wire:target="updateProfile" style="display:flex; align-items:center; gap:6px;"><span style="width:16px;height:16px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Saving...</span>
                </button>
                <style>@keyframes spin{to{transform:rotate(360deg)}}</style>
            </form>
        </div>
    </div>
</div>
</div>
