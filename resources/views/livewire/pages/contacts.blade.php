<div>
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:var(--muk-green-dark); margin-bottom:8px;">
            Contact Us
        </h1>
        <p style="font-size:14px; color:#9a9a9a;">
            Get in touch with Makerere University Sports Department and colleges
        </p>
    </div>

    {{-- MAIN LOCATION --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
            <span style="font-size:20px;">📍</span>
            <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                Main Campus Location
            </h2>
        </div>
        <p style="font-size:14px; color:#444; line-height:1.7; margin-bottom:4px;">
            <strong>Makerere University</strong><br>
            Makerere Hill Road, Kampala, Uganda
        </p>
        <p style="font-size:13px; color:#666;">
            P.O. Box 7062, Kampala, Uganda
        </p>
    </div>

    {{-- TWO COLUMN LAYOUT --}}
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
        {{-- SPORTS DEPARTMENT --}}
        <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #e5e7eb;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                <span style="font-size:20px;">🏅</span>
                <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                    Department of Sports & Recreation
                </h2>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <div style="margin-bottom:4px;"><strong>📞 Phone:</strong> +256-704-923105</div>
                <div style="margin-bottom:4px;"><strong>📧 Email:</strong> <a href="mailto:sports@mak.ac.ug" style="color:var(--muk-green); text-decoration:none; font-weight:600;">sports@mak.ac.ug</a></div>
                <div style="margin-bottom:4px;"><strong>🏢 Office:</strong> Sports Pavilion, Lower Campus</div>
                <div style="margin-bottom:4px;"><strong>🕐 Hours:</strong> Mon–Fri, 8:00 AM – 5:00 PM</div>
            </div>
        </div>

        {{-- ADMIN OFFICE --}}
        <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #e5e7eb;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                <span style="font-size:20px;">🏛️</span>
                <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                    Administrator Office
                </h2>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <div style="margin-bottom:4px;"><strong>📞 Phone:</strong> +256-414-542803</div>
                <div style="margin-bottom:4px;"><strong>📧 Email:</strong> <a href="mailto:admin.sports@mak.ac.ug" style="color:var(--muk-green); text-decoration:none; font-weight:600;">admin.sports@mak.ac.ug</a></div>
                <div style="margin-bottom:4px;"><strong>🏢 Office:</strong> Senate Building, Room 210</div>
                <div style="margin-bottom:4px;"><strong>👤 Dean of Students:</strong> <a href="mailto:deanofstudents@mak.ac.ug" style="color:var(--muk-green); text-decoration:none; font-weight:600;">deanofstudents@mak.ac.ug</a></div>
            </div>
        </div>
    </div>

    {{-- COLLEGES TABLE --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <span style="font-size:20px;">🎓</span>
            <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                Colleges & Contact Emails
            </h2>
        </div>
        <div class="table-wrap">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:var(--muk-green); color:#fff;">
                        <th style="padding:10px 14px; text-align:left; font-weight:700;">College</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:700;">Abbreviation</th>
                        <th style="padding:10px 14px; text-align:left; font-weight:700;">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $colleges = [
                            ['College of Humanities and Social Sciences', 'CHUSS', 'chuss@mak.ac.ug'],
                            ['College of Natural Sciences', 'CoNAS', 'conas@mak.ac.ug'],
                            ['College of Health Sciences', 'CHS', 'chs@mak.ac.ug'],
                            ['College of Business and Management Sciences', 'CoBAMS', 'cobams@mak.ac.ug'],
                            ['College of Engineering, Design, Art and Technology', 'CEDAT', 'cedat@mak.ac.ug'],
                            ['College of Agricultural and Environmental Sciences', 'CAES', 'caes@mak.ac.ug'],
                            ['College of Education and External Studies', 'CEES', 'cees@mak.ac.ug'],
                            ['College of Computing and Information Sciences', 'CoCIS', 'cocis@mak.ac.ug'],
                            ['College of Veterinary Medicine, Animal Resources and Biosecurity', 'COVAB', 'covab@mak.ac.ug'],
                        ];
                    @endphp
                    @foreach($colleges as $college)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:10px 14px; color:#333;">{{ $college[0] }}</td>
                            <td style="padding:10px 14px; color:#666; font-weight:600;">{{ $college[1] }}</td>
                            <td style="padding:10px 14px;">
                                <a href="mailto:{{ $college[2] }}" style="color:var(--muk-green); text-decoration:none; font-weight:600;">
                                    {{ $college[2] }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- VENUES --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <span style="font-size:20px;">🏟️</span>
            <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                Sports Venues
            </h2>
        </div>
        @if($venues->count())
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                @foreach($venues as $venue)
                    <div style="padding:14px; background:#f9f9f9; border-radius:10px; border:1px solid #eee;">
                        <div style="font-size:14px; font-weight:700; color:#111; margin-bottom:4px;">{{ $venue->name }}</div>
                        @if($venue->location)
                            <div style="font-size:12px; color:#666;">📍 {{ $venue->location }}</div>
                        @endif
                        @if($venue->capacity)
                            <div style="font-size:12px; color:#666;">👥 Capacity: {{ $venue->capacity }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p style="font-size:13px; color:#888; text-align:center; padding:20px;">Venue information coming soon.</p>
        @endif
    </div>

    {{-- OTHER CONTACTS --}}
    <div style="background:#fff; border-radius:12px; padding:24px; border:1px solid #e5e7eb;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <span style="font-size:20px;">📬</span>
            <h2 style="font-size:16px; font-weight:800; color:var(--muk-green-dark);">
                Other Important Contacts
            </h2>
        </div>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 Vice Chancellor's Office:</strong><br>
                <a href="mailto:vc@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">vc@mak.ac.ug</a>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 Academic Registrar:</strong><br>
                <a href="mailto:academic.registrar@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">academic.registrar@mak.ac.ug</a>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 University Secretary:</strong><br>
                <a href="mailto:university.secretary@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">university.secretary@mak.ac.ug</a>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 IT Support (Portal):</strong><br>
                <a href="mailto:itsupport@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">itsupport@mak.ac.ug</a>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 Library:</strong><br>
                <a href="mailto:library@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">library@mak.ac.ug</a>
            </div>
            <div style="font-size:13px; color:#444; line-height:1.8;">
                <strong>📧 Guild Office:</strong><br>
                <a href="mailto:guild@mak.ac.ug" style="color:var(--muk-green); text-decoration:none;">guild@mak.ac.ug</a>
            </div>
        </div>
    </div>

    <style>
        @media(max-width:768px) {
            [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</div>
