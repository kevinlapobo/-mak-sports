<x-filament-panels::page>
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:12px;">

        <button wire:click="selectReport('users')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#059669,#10b981); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'users' ? 'outline:3px solid #047857; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Total Users</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['users'] }}</div>
        </button>
        <button wire:click="selectReport('pending')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#dc2626,#f87171); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'pending' ? 'outline:3px solid #b91c1c; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Pending Approvals</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['pending'] }}</div>
        </button>
        <button wire:click="selectReport('teams')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#2563eb,#60a5fa); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'teams' ? 'outline:3px solid #1d4ed8; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Teams</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['teams'] }}</div>
        </button>
        <button wire:click="selectReport('players')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#7c3aed,#a78bfa); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'players' ? 'outline:3px solid #6d28d9; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Players</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['players'] }}</div>
        </button>
        <button wire:click="selectReport('coaches')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#d97706,#fbbf24); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'coaches' ? 'outline:3px solid #b45309; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Coaches</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['coaches'] }}</div>
        </button>
        <button wire:click="selectReport('matches')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#0891b2,#22d3ee); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'matches' ? 'outline:3px solid #0e7490; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Total Matches</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['matches'] }}</div>
        </button>
        <button wire:click="selectReport('completed')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#059669,#34d399); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'completed' ? 'outline:3px solid #047857; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Completed Matches</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['completed'] }}</div>
        </button>
        <button wire:click="selectReport('bookings')" type="button" style="border:none; cursor:pointer; text-align:left; background:linear-gradient(135deg,#be185d,#f472b6); padding:20px; border-radius:12px; color:#fff; {{ $selectedReport === 'bookings' ? 'outline:3px solid #9d174d; outline-offset:2px;' : '' }}">
            <div style="font-size:11px; opacity:.7; text-transform:uppercase; letter-spacing:1px;">Venue Bookings</div>
            <div style="font-size:32px; font-weight:900;">{{ $stats['bookings'] }}</div>
        </button>
    </div>

    {{-- Detail Table --}}
    @if(count($details))
    <div style="margin-top:24px; background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:16px 20px; background:#f9fafb; border-bottom:1px solid #e5e7eb;">
            <h3 style="font-size:16px; font-weight:700; color:#333; margin:0; text-transform:capitalize;">{{ $selectedReport }} Report</h3>
            <div style="display:flex; gap:8px;">
                <button onclick="downloadCSV()" style="padding:8px 16px; background:var(--muk-green); color:#fff; border:none; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">⬇ Download CSV</button>
                <button onclick="window.print()" style="padding:8px 16px; background:#f3f4f6; color:#333; border:1px solid #e5e7eb; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">🖨 Print</button>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table id="report-table" style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                        @foreach(array_keys($details[0]) as $header)
                        <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333; text-transform:capitalize;">{{ str_replace('_', ' ', $header) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $row)
                    <tr style="border-bottom:1px solid #f0f0f0;">
                        @foreach($row as $cell)
                        <td style="padding:12px 14px;">{{ $cell }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(count($totals))
        <div style="padding:14px 20px; background:#f9fafb; border-top:2px solid #e5e7eb; display:flex; gap:20px; flex-wrap:wrap;">
            @foreach($totals as $label => $count)
            <span style="font-size:13px; font-weight:600; color:#333;">
                {{ $label }}: <span style="color:var(--muk-green);">{{ $count }}</span>
            </span>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    @push('scripts')
    <script>
    function downloadCSV() {
        const table = document.getElementById('report-table');
        if (!table) return;
        const rows = table.querySelectorAll('tr');
        let csv = '';
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const vals = Array.from(cells).map(c => '"' + c.textContent.trim().replace(/"/g, '""') + '"');
            csv += vals.join(',') + '\n';
        });
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = '{{ $selectedReport }}-report.csv';
        a.click();
        URL.revokeObjectURL(url);
    }
    </script>
    @endpush

    <style>
    @media print {
        .filament-sidebar, .filament-topbar, button, .fi-sidebar, .fi-topbar { display: none !important; }
        body { background: #fff !important; }
        #report-table { font-size: 11px !important; }
        #report-table th { background: #333 !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        [style*="background:linear-gradient"] { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
    </style>
</x-filament-panels::page>
