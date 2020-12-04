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
								<label for="propietario">Nombre o Username (propietario)</label>
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
								<small id="helpId" class="text-muted">Procura que no sobrepase 2mb y que sea de tipo png o jpg)</small><br>
								<label id="helpId" class="text-danger" v-if="errors.fotoSeleccionada.length">{{errors.fotoSeleccionada}}</label>
							</div>
							<!-- Imagen -->

							<!-- articulo -->
							<div class="form-group col-sm-12">
								<vue-editor v-model="articulo" :editor-toolbar="barraHerramientas" ></vue-editor>
								<label id="helpId" class="text-danger" v-if="errors.articulo.length">{{errors.articulo}}</label>
							</div>
							<!-- articulo -->

							<!-- articulo -->
							<div class="col-sm-12">
								<button type="button" class="btn btn-primary float-right" @click="guardarPost" :disabled="btnLock">Guardar</button>
							</div>
							<!-- articulo -->
						</div>
						<!-- <div class="row ql-snow">
							<div class="col-sm-12 ql-editor" v-html="content"></div>
						</div> -->
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
				propietario: '',
				titulo: '',
				articulo: '',
				fotoSeleccionada: null,
				clickGuardar: false,
				btnLock: false,
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
				let tiposPermitidos = ['image/jpeg', 'image/png']
				this.fotoSeleccionada = event.target.files[0]

				if (!tiposPermitidos.includes(this.fotoSeleccionada.type)) {
					this.$notify({
						type: 'warn',
						group: 'notificacionArticulo',
						title: 'Cuidado',
						text: 'Verifique sus errores por favor.'
					})
					this.fotoSeleccionada = null
					event.target.value = ''
				}

				if (this.fotoSeleccionada.size > 2e6) {
					this.$notify({
						type: 'warn',
						group: 'notificacionArticulo',
						title: 'Cuidado',
						text: 'La imagen pesa mas de 2mb'
					})
					this.fotoSeleccionada = null
					event.target.value = ''
				}

			},
			guardarPost(){
				this.clickGuardar = true

				if (this.errors.exist) {
					this.$notify({
						type: 'error',
						group: 'notificacionArticulo',
						title: 'Error',
						text: 'Verifique sus errores por favor.'
					})
					return;
				}

				let formulario = new FormData();
				formulario.append('propietario', this.propietario)
				formulario.append('titulo', this.titulo)
				formulario.append('articulo', this.articulo)
				formulario.append('foto', this.fotoSeleccionada, this.fotoSeleccionada.name)

				this.btnLock = true
				axios.post('articulo', formulario)
					.then(response => {
						this.$notify({
							type: response.data.success ? 'success' : 'error',
							group: 'notificacionArticulo',
							title: response.data.success ?  'Ok' : 'Hubo un error',
							text: response.data.message
						})

						if (response.data.success) {
							setTimeout(() => {
								window.location.replace('/')
							}, 1000);
						}
					})
					.catch(error => {
						this.$notify({
							type: 'warning',
							group: 'notificacionArticulo',
							title: ':c Creo que hubo un error',
							text: 'Al parecer hubo un error en el servidor, intente de nuevo'
						})
					})
					.finally(() => {
						this.btnLock = false
					})
			}
		},
		computed: {
			errors() {
				if (!this.clickGuardar) {
				return {
						propietario: '',
						titulo: '',
						articulo: '',
						fotoSeleccionada: '',
						exist: false
					}
				}

				let errores = {
					propietario: this.propietario.trim().length ? '' : 'Ingrese un username',
					titulo: this.titulo.trim().length ? '' : 'Ingrese un título',
					articulo: this.articulo.length ? '' : 'Es necesario el articulo del post',
					fotoSeleccionada: this.fotoSeleccionada ? '' : 'Es necesaria una imagen',
					exist: false
				}

				for (const key in errores) {
					if (key != 'errores' && errores[key].length) {
						errores.exist = true
						break;
					}
				}

				return errores
			}
		}
};
</script>
