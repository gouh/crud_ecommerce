<template>
	<div class="container">
		<div class="row justify-content-center">

			<!-- Articulos -->
			<div class="col-md-12" v-for="articulo in articulos" :key="articulo.id">
				<div class="mt-2 card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<img :src="'images/' + articulo.foto" class="img-thumbnail" height="100" width="100">
							</div>
							<div class="col-sm-10">
								<h4>{{articulo.titulo}} <small>Escrito por <i>{{articulo.propietario}}</i></small></h4>
								<div class="row ql-snow">
									<div class="col-sm-12 ql-editor" v-html="articulo.articulo.substring(0,100)"></div>
								</div>
								<a class="btn btn-primary float-right" href="#" @click.prevent="abrirArticulo(articulo.id)">Seguir leyendo</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12" v-if="articulos.length == 0">
				<div class="max-w-xl mx-auto sm:px-6 lg:px-8">
						<div class="flex items-center pt-8 sm:justify-start sm:pt-0 text-center">
								<div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">No hay articulos 😔</div>
						</div>
				</div>
			</div>

			<!-- Paginación -->
			<div class="col-sm-12">
				<ul class="pagination mt-3 float-right">
					<li class="page-item" v-for="link in links" :key="link.label" :class="{'active': link.active}">
						<a href="#" class="page-link" @click.prevent="obtenerPagina(link.url)">
							<span v-html="link.label"></span>
						</a>
					</li>
				</ul>
			</div>

		</div>
		<notifications group="notificacionArticulo" />
	</div>
</template>

<script>
import { VueEditor } from "vue2-editor";
export default {
		data(){
			return {
				articulos: '',
				links: []
			}
		},
		methods: {
			listarArticulos(){
				axios.get('articulos')
					.then(response => {
						this.articulos = response.data.data
						this.links = response.data.links
					})
			},
			obtenerPagina(url){
				if (url != null) {
					axios({ url: '', baseURL: url })
						.then(response => {
							this.articulos = response.data.data
							this.links = response.data.links
						})
				}
			},
			abrirArticulo(idArticulo){
				window.location.href = 'articulo/'+ idArticulo
			}
		},
		mounted(){
			this.listarArticulos();
		}
};
</script>
