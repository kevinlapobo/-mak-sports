<div>

{{-- ARTICLE --}}
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:800px; margin:0 auto;">

        {{-- Back link --}}
        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back to Home
        </a>

        {{-- Article Header --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden; margin-bottom:24px;">
            <div style="height:240px; background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-size:48px;">📰</div>
            <div style="padding:32px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <span style="background:var(--muk-green); color:#fff; font-size:10px; font-weight:700; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:.5px;">{{ $news->category ?? 'Sports' }}</span>
                    <span style="font-size:12px; color:#888;">{{ $news->published_at?->format('d M, Y') ?? 'Recent' }}</span>
                    <span style="font-size:12px; color:#888;">by {{ $news->author ?? 'Sports Desk' }}</span>
                </div>
                <h1 style="font-size:28px; font-weight:900; color:var(--muk-black); line-height:1.2; margin-bottom:20px;">{{ $news->title }}</h1>
                <div style="font-size:15px; line-height:1.8; color:#333;" class="article-content">
                    {!! nl2br(e($news->body)) !!}
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div id="action-buttons" style="display:flex; gap:10px; margin-bottom:32px; flex-wrap:wrap;"
            data-title="{{ addslashes($news->title) }}"
            data-body="{{ addslashes($news->body) }}"
            date="{{ addslashes($news->published_at?->format('d M, Y') ?? 'Recent') }}"
            author="{{ addslashes($news->author ?? 'Sports Desk') }}"
        >
            <button id="btn-print" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">
                🖨️ Print Article
            </button>
            <button id="btn-download" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">
                📥 Download
            </button>
            <button id="btn-share" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">
                🔗 Share
            </button>
        </div>

        {{-- Toast Notification --}}
        <div id="toast" style="display:none; position:fixed; bottom:30px; left:50%; transform:translateX(-50%); background:#006633; color:#fff; padding:12px 24px; border-radius:10px; font-size:14px; font-weight:600; z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,.25); transition:opacity .3s;"></div>

        {{-- Related News --}}
        @if($related->count() > 0)
        <div>
            <div class="section-title">More News</div>
            <div class="section-heading">Related Stories</div>
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-top:20px;">
                @foreach($related as $item)
                <a href="{{ route('news.detail', $item->id) }}" class="news-card">
                    <div style="height:120px; background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px;">📰</div>
                    <div class="news-body">
                        <div class="news-tag">{{ $item->category ?? 'Sports' }}</div>
                        <div class="news-title">{{ Str::limit($item->title, 60) }}</div>
                        <div class="news-date">{{ $item->published_at?->format('d M, Y') ?? 'Recent' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<style>
@media print {
    #main-nav, footer, #action-buttons, #toast { display: none !important; }
    .article-content { color: #000 !important; }
    body { padding-top: 0 !important; }
    .container { max-width: 100% !important; }
}
</style>

<script>
(function() {
    var wrap = document.getElementById('action-buttons');
    if (!wrap) return;

    var title  = wrap.getAttribute('data-title');
    var body   = wrap.getAttribute('data-body');
    var date   = wrap.getAttribute('date');
    var author = wrap.getAttribute('author');

    function showToast(msg) {
        var t = document.getElementById('toast');
        t.textContent = msg;
        t.style.display = 'block';
        t.style.opacity = '1';
        setTimeout(function() {
            t.style.opacity = '0';
            setTimeout(function() { t.style.display = 'none'; }, 300);
        }, 2500);
    }

    /* Print */
    document.getElementById('btn-print').addEventListener('click', function() {
        window.print();
    });

    /* Download as HTML */
    document.getElementById('btn-download').addEventListener('click', function() {
        var paragraphs = body.split('\n').filter(function(p) { return p.trim().length > 0; });
        var pTags = paragraphs.map(function(p) { return '<p>' + p + '</p>'; }).join('\n');

        var html = [
            '<!DOCTYPE html>',
            '<html><head><meta charset="utf-8"><title>' + title + '</title>',
            '<style>body{font-family:Arial,Helvetica,sans-serif;max-width:700px;margin:40px auto;padding:20px;color:#333;}',
            'h1{color:#006633;font-size:24px;margin-bottom:8px;}',
            '.meta{color:#888;font-size:12px;margin-bottom:24px;border-bottom:2px solid #006633;padding-bottom:12px;}',
            'p{line-height:1.8;font-size:14px;margin-bottom:12px;}',
            '</style></head><body>',
            '<h1>' + title + '</h1>',
            '<div class="meta">' + date + ' | By ' + author + ' | MAKSPORTS</div>',
            pTags,
            '</body></html>'
        ].join('\n');

        try {
            var blob = new Blob([html], { type: 'text/html;charset=utf-8' });
            var url  = URL.createObjectURL(blob);
            var a    = document.createElement('a');
            a.href     = url;
            a.download = title.replace(/[^a-z0-9\s]/gi, '').replace(/\s+/g, '_').toLowerCase().substring(0, 60) + '.html';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('Article downloaded!');
        } catch(e) {
            showToast('Download failed. Try again.');
        }
    });

    /* Share / Copy Link */
    document.getElementById('btn-share').addEventListener('click', function() {
        var shareUrl = window.location.href;
        if (navigator.share) {
            navigator.share({ title: title, url: shareUrl }).catch(function() {});
        } else {
            var ta = document.createElement('textarea');
            ta.value = shareUrl;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try {
                document.execCommand('copy');
                showToast('Link copied to clipboard!');
            } catch(e) {
                showToast('Unable to copy link.');
            }
            document.body.removeChild(ta);
        }
    });
})();
</script>
</div>
