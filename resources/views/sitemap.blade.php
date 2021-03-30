<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($results as $item)
        <url>
            <loc>{{ config('app.url') }}/{{ str_replace(' ', '-', $item->title) }}</loc>
            <lastmod>{{ $item->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>hourly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset> 