<?php
$json = __DIR__ . '/DESCRICOES/data.json';
echo '<script> const descricoesTorax = ' . file_get_contents( $json ) . '; </script>'
?>

<select class="descricoes-torax">
	<option value="">Descrições Cirúrgicas</option>
</select>

<script>
	// Adiciona os nomes do JSON ao select
	descricoesTorax .forEach( ( item, index ) => {
		const option = document .createElement( "option" );

		option .value = index;
		option .textContent = item .nome;

		document. querySelector( "select.descricoes-torax" ) 
			.appendChild( option );
	});
</script>
