<template>
	<div id="teste" class="">
		<strong><h3>Aprovacao Gerencial : </h3></strong><h3>Ana</h3>
		<strong><h3>Aprovacao Tecnica : </h3></strong><h3>Nao Ha</h3>
		<strong><h3>Aprovação EHS (Segurança, Saúde e Meio Ambiente): </h3></strong><h3>Nao Ha</h3>
		<input type="button" class="primary" :value="t('procedure', 'Editar')">
		<hr>
		<strong><h3>Pessoas do Departamento:</h3></strong>
		<ul>
			<li>
				<p>ana@amplargs.com.br</p>
			</li>
			<li>
				<p>mauro@amplargs.com.br</p>
			</li>
		</ul>
	</div>
</template>

<script>

export default {
	name: 'SharingTab',

	components: {
	},
	data() {
		return {
		}
	},
	computed: {
	},
	methods: {
	},
}
</script>

<style scoped lang="scss">
</style>
