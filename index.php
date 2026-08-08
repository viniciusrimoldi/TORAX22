<?php
header('charset=utf-8');

$diretorio = __DIR__ . '/descricoes';
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
