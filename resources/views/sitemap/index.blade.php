<?php
/**
 * Created by PhpStorm.
 * User: iFeras93
 * Date: 9/10/2017
 * Time: 9:11 PM
 */ ?>

<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ $url.'words' }}</loc>
        <lastmod>{{ $words->created_at }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{ $url.'discharges' }}</loc>
        <lastmod>{{ $discharges->created_at }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{ $url.'medical' }}</loc>
        <lastmod>{{ $medical->created_at }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{ $url.'shortcuts' }}</loc>
        <lastmod>{{ $shortcuts->created_at }}</lastmod>
    </sitemap>

    <sitemap>
        <loc>{{ $url.'slang' }}</loc>
        <lastmod>{{ $slang->created_at }}</lastmod>
    </sitemap>

</sitemapindex>
