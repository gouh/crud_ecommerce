<template>
	<div class="container">
		<div class="row justify-content-center">

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
								<button type="button" class="btn btn-primary float-right">Seguir leyendo</button>
							</div>
						</div>
					</div>
				</div>
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
				articulos: ''
			}
		},
		methods: {
			listarArticulos(){
				axios.get('articulos')
					.then(response => {
						this.articulos = response.data.data
					})
			}
		},
		mounted(){
			this.listarArticulos();
		}
};
</script>
