<?php

namespace App\Controllers;

use app\controllers\Controller;

class AssetsController extends Controller
{
    public function favicon()
    {
        // Retornar resposta vazia para favicon.ico
        header('Content-Type: image/x-icon');
        header('Content-Length: 0');
        http_response_code(204); // No Content
        exit;
    }

    public function robots()
    {
        // Retornar robots.txt básico
        header('Content-Type: text/plain');
        echo "User-agent: *\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /config/\n";
        exit;
    }

    public function sitemap()
    {
        // Retornar sitemap.xml básico
        header('Content-Type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        echo '  <url>' . "\n";
        echo '    <loc>http://localhost/PHP-POO/routes-phpoo/public/index.php</loc>' . "\n";
        echo '    <changefreq>daily</changefreq>' . "\n";
        echo '    <priority>1.0</priority>' . "\n";
        echo '  </url>' . "\n";
        echo '</urlset>' . "\n";
        exit;
    }
}
