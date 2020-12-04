<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header text-center">Nuevo articulo (Todas las entradas de este formulario son requeridas)</div>
					<div class="card-body">
						<div class="row">
							<!-- Username -->
							<div class="form-group col-sm-6">
								<label for="propietario">Nombre o Username (Del propietario)</label>
								<input type="text" name="propietario" id="propietario"  class="form-control" :maxlength="50" v-model="propietario">
								<small id="helpId" class="text-muted">máximo 50 caracteres ({{propietario.length + '/50'}})</small><br>
								<label id="helpId" class="text-danger" v-if="errors.propietario.length">{{errors.propietario}}</label>
							</div>
							<!-- Username -->

							<!-- titulo -->
							<div class="form-group col-sm-6">
								<label for="titulo">Título</label>
								<input type="text" name="titulo" id="titulo"  class="form-control" :maxlength="50" v-model="titulo">
								<small id="helpId" class="text-muted">máximo 50 caracteres ({{titulo.length + '/50'}})</small><br>
								<label id="helpId" class="text-danger" v-if="errors.titulo.length">{{errors.titulo}}</label>
							</div>
							<!-- titulo -->

							<!-- Imagen -->
							<div class="form-group col-sm-12">
								<label for="foto">Foto (Esta será la portada y miniatura de tu post)</label>
								<input type="file" name="foto" id="foto" class="form-control-file" @change="archivoSeleccionado">
								<small id="helpId" class="text-muted">Procura que no sobrepase 2mb)</small><br>
								<label id="helpId" class="text-danger" v-if="errors.fotoSeleccionada.length">{{errors.fotoSeleccionada}}</label>
							</div>
							<!-- Imagen -->

							<!-- Contenido -->
							<div class="form-group col-sm-12">
								<vue-editor v-model="contenido" :editor-toolbar="barraHerramientas" ></vue-editor>
								<label id="helpId" class="text-danger" v-if="errors.contenido.length">{{errors.contenido}}</label>
							</div>
							<!-- Contenido -->

							<!-- Contenido -->
							<div class="col-sm-12">
								<button type="button" class="btn btn-primary float-right" @click="guardarPost">Guardar</button>
							</div>
							<!-- Contenido -->
						</div>
						<!-- <div class="row ql-snow">
							<div class="col-sm-12 ql-editor" v-html="content"></div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { VueEditor } from "vue2-editor";
export default {
		data(){
			return {
				propietario: '',
				titulo: '',
				contenido: '',
				fotoSeleccionada: null,
				clickGuardar: false,
				barraHerramientas: [
					[{ 'font': [] }],
					[{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
					['bold', 'italic', 'underline', 'strike'],
					[{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
					['blockquote', 'code-block'],
					[{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
					[{ 'indent': '-1'}, { 'indent': '+1' }],
				]
			}
		},
		methods: {
			archivoSeleccionado(event) {
				this.fotoSeleccionada = event.target.files[0]
			},
			guardarPost(){
				this.clickGuardar = true
				// let formulario = new FormData();
				// formulario.append('foto', this.selectedFile)
				// formulario.append('contenido', this.selectedFile)
				// formulario.append('propietario', this.selectedFile)
				// formulario.append('titulo', this.selectedFile)
			}
		},
		computed: {
			errors() {
				if (!this.clickGuardar) {
				return {
						propietario: '',
						titulo: '',
						contenido: '',
						fotoSeleccionada: ''
					}
				}

				return {
					propietario: this.propietario.length ? '' : 'Ingrese un username',
					titulo: this.titulo.length ? '' : 'Ingrese un título',
					contenido: this.contenido.length ? '' : 'Es necesario el contenido del post',
					fotoSeleccionada: this.fotoSeleccionada ? '' : 'Es necesaria una imagen'
				}
			}
		}
};
</script>
