<?php

$slug = $_GET['slug'] ?? 'home';

require __DIR__ . '/core/markdown.php';

$file = __DIR__ . "/conteudo/$slug.md";

if ( !file_exists( $file ) ) {
    http_response_code(404);
    echo "Página não encontrada";
    exit;
}

$content = file_get_contents( $file );

$data = parseMarkdownWithMeta( $content );

require __DIR__ . '/templates/page.php';
