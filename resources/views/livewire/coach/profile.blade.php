<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:650px; margin:0 auto;">

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px 24px;">
                <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">👤 Coach Profile</h1>
            </div>

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid #CC0000; padding:16px 20px; margin:16px; border-radius:0 8px 8px 0;">
                <div style="font-size:14px; font-weight:700; color:#CC0000;">⚠️ Please fix the following:</div>
                <ul style="margin:8px 0 0 20px; font-size:13px; color:#333;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form wire:submit="updateProfile" style="padding:24px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Full Name <span style="color:#CC0000;">*</span></label>
                        <input type="text" wire:model="full_name" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Phone</label>
                        <input type="text" wire:model="phone" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; background:#f9fafb;">
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

                <button type="submit" style="width:100%; padding:14px; background:#CC0000; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer;">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</div>
</div>
