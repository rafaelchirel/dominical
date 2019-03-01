<template>
	<div class="row">
        <div class="col-xs-12">
            <h1 class="page-head-line titulo">{{ title }}</h1>
        </div>
    </div>
</template>

<script>
	export default {
		props: ['title']
	}
</script>

<style>
	@media screen and (max-width: 296px){
		.titulo {
			font-size: 15px;
		}
	}
</style>