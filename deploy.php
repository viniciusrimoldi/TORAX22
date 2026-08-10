<?php
header('charset=utf-8');

$git_usuario = 'viniciusrimoldi';
$git_repositorio = 'TORAX22';

$url = "https://github.com/$git_usuario/$git_repositorio/archive/refs/heads/main.zip";

$zipFile = 'tmp/repositorio.zip';

file_put_contents( $zipFile, fopen( $url, 'r' ) );

$zip = new ZipArchive();

if ( $zip->open( $zipFile ) === true) {

	$zip->extractTo( __DIR__ );
	$zip->close();

	unlink( $zipFile );


	// Cria o json com as descricoes.
	$diretorio = __DIR__ . "/$git_repositorio-main/DESCRICOES";
	$file_json = __DIR__ . "/$git_repositorio-main/DESCRICOES/data.json";
	$resultado = [];

	foreach (scandir($diretorio) as $arquivo) {
		if ($arquivo === '.' || $arquivo === '..') {
			continue;
		}

		$caminho = $diretorio . DIRECTORY_SEPARATOR . $arquivo;

		// Ignora subdiretórios
		if (!is_file($caminho)) {
			continue;
		}

		$resultado[] = [
			'nome' => $arquivo,
			'conteudo' => file_get_contents($caminho)
		];
	}


	// Cria um arquivo json com as descricoes.
	file_put_contents( 
		$file_json,
		json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
	);




	// Mensagem de sucesso para usuário.
	echo "\nRepositório instalado com sucesso.";

} else {
	echo "\nErro ao abrir o ZIP.";
}
