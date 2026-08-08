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


const editor = document .querySelector( "textarea.editor" );

editor.addEventListener('keydown', function (e) {
    const start = this.selectionStart;
    const end = this.selectionEnd;
    const value = this.value;

    // Tab -> 4 espaços
    if (e.key === 'Tab') {
        e.preventDefault();

        this.setRangeText(
            '    ',
            start,
            end,
            'end'
        );

        return;
    }

    // Ctrl+C sem seleção -> copia a linha atual
    if (e.ctrlKey && e.key.toLowerCase() === 'c' && start === end) {
        e.preventDefault();

        const lineStart = value.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = value.indexOf('\n', start);

        if (lineEnd === -1) {
            lineEnd = value.length;
        }

        const line = value.substring(lineStart, lineEnd);

        navigator.clipboard.writeText(line);
        return;
    }

    // Ctrl+X sem seleção -> recorta a linha atual
    if (e.ctrlKey && e.key.toLowerCase() === 'x' && start === end) {
        e.preventDefault();

        const lineStart = value.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = value.indexOf('\n', start);

        if (lineEnd === -1) {
            lineEnd = value.length;
        }

        // Inclui a quebra de linha, quando existir
        const deleteEnd = lineEnd < value.length
            ? lineEnd + 1
            : lineStart > 0
                ? lineStart - 1
                : lineEnd;

        const line = value.substring(lineStart, lineEnd);

        navigator.clipboard.writeText(line);

        this.value =
            value.substring(0, lineStart) +
            value.substring(deleteEnd);

        this.selectionStart = this.selectionEnd =
            Math.min(lineStart, this.value.length);

        return;
    }

    // Ctrl+D sem seleção -> deleta a linha atual
    if (e.ctrlKey && e.key.toLowerCase() === 'd' && start === end) {
        e.preventDefault();

        const lineStart = value.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = value.indexOf('\n', start);

        if (lineEnd === -1) {
            lineEnd = value.length;
        }

        const deleteEnd = lineEnd < value.length
            ? lineEnd + 1
            : lineStart > 0
                ? lineStart - 1
                : lineEnd;

        this.value =
            value.substring(0, lineStart) +
            value.substring(deleteEnd);

        this.selectionStart = this.selectionEnd =
            Math.min(lineStart, this.value.length);
    }
});

</script>
    </body>
</html>
