<div style="position:relative; display:inline-flex; align-items:center;">
    <a href="{{ route('notifications') }}" style="position:relative; color:rgba(255,255,255,.85); text-decoration:none; padding:6px; border-radius:8px; transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.12)'" onmouseout="this.style.background='transparent'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        @if($count > 0)
            <span style="position:absolute; top:-2px; right:-4px; background:var(--muk-red); color:#fff; font-size:9px; font-weight:800; min-width:18px; height:18px; border-radius:999px; display:flex; align-items:center; justify-content:center; border:2px solid var(--muk-green);">
                {{ $count > 99 ? '99+' : $count }}
            </span>
        @endif
    </a>
</div>
