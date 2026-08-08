<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">

        <title>TORAX22</title>

        <meta name="description" content="Informações sobre descrições cirurgicas em cirurgia torácica">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> TORAX22 - Cirurgia Torácica </title>

        <style>
			select.descricoes-torax {
				width: 98vw;
			    padding: 4px;
			}
			
			textarea.editor {
				width: 96vw;
			    height: 500px;
			    padding: 12px;
			}
			
        </style>
	</head>
	<body>
        
<?php
header('charset=utf-8');

$diretorio = __DIR__ . '/DESCRICOES';
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

echo '<script> const descricoesTorax = '
	. json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) 
	. '; </script>';

?>

<select class="descricoes-torax">
	<option value="">Descrições Cirúrgicas</option>
</select>

<br>

<textarea class="editor"></textarea>


<script>

	// Cria o select
	const select = document. querySelector( "select.descricoes-torax" );
	
	
	// Adiciona os nomes do JSON ao select
	descricoesTorax .forEach( ( item, index ) => {
		const option = document .createElement( "option" );

		option .value = index;
		option .textContent = item .nome;

		select .appendChild( option );
	});


	// Quando selecionar uma opção
	select .addEventListener( "change", function () {
		const itemSelecionado = descricoesTorax[ this .value ];

		if ( itemSelecionado ) {
			document .querySelector( "textarea.editor" ) .value = 
				itemSelecionado .conteudo;
		}
	});

</script>
    </body>
</html>
