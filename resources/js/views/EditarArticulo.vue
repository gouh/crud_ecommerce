<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header text-center">Edición de articulo (Edite los campos que desea cambiar)</div>
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

							<div class="col-sm-12 text-center" v-if="imagen">
								<img :src="url + '/images/' + imagen" class="img-thumbnail" height="100" width="100">
								<br>
								<small>Esta imagen se conservará a menos que la cambies</small>
							</div>

							<!-- Imagen -->
							<div class="form-group col-sm-12">
								<label for="foto">Foto (Esta será la portada y miniatura de tu post)</label>
								<input type="file" name="foto" id="foto" class="form-control-file" @change="archivoSeleccionado">
								<small id="helpId" class="text-muted">Procura que no sobrepase 2mb y que sea de tipo png o jpg)</small><br>
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
		props: ['id', 'url'],
		data(){
			return {
				imagen: '',
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
			obtenerArticulo(){
				axios.get('articulo_comentarios/' + this.id)
					.then(response => {
						let res = response.data
						this.imagen = res.foto
						this.propietario = res.propietario
						this.titulo = res.titulo
						this.articulo = res.articulo
					})
			},
			archivoSeleccionado(event) {
				let tiposPermitidos = ['image/jpeg', 'image/png']
				this.fotoSeleccionada = event.target.files[0]

				if (!tiposPermitidos.includes(this.fotoSeleccionada.type)) {
					this.$swal('Cuidado', 'La imagen no tiene un formato valido.', 'error')
					this.fotoSeleccionada = null
					event.target.value = ''
				}

				if (this.fotoSeleccionada.size > 2e6) {
					this.$swal('Cuidado', 'La imagen pesa mas de 2mb', 'error')
					this.fotoSeleccionada = null
					event.target.value = ''
				}

			},
			guardarPost(){
				this.clickGuardar = true

				if (this.errors.exist) {
					this.$swal('Error', 'Verifique sus errores por favor.', 'error')
					return;
				}

				let formulario = new FormData();
				formulario.append('id', this.id)
				formulario.append('propietario', this.propietario)
				formulario.append('titulo', this.titulo)
				formulario.append('articulo', this.articulo)
				if (this.fotoSeleccionada != null) {
					formulario.append('foto', this.fotoSeleccionada, this.fotoSeleccionada.name)
				}else{
					formulario.append('foto', '')
				}

				this.btnLock = true
				axios.post('update/articulo', formulario)
					.then(response => {
						this.$swal({
							title: 'Atención',
							html: response.data.message,
							confirmButtonText:'Ok',
							icon: response.data.success ? 'success' : 'error'
						}).then(result => {
							if (response.data.success) {
								window.location.replace('/')
							}
						})
					})
					.catch(error => {
						this.$swal({
							title: 'Atención',
							html: ':c Creo que hubo un error',
							confirmButtonText:'Ok',
							icon: 'error'
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
						exist: false
					}
				}

				let errores = {
					propietario: this.propietario.trim().length ? '' : 'Ingrese un username',
					titulo: this.titulo.trim().length ? '' : 'Ingrese un título',
					articulo: this.articulo.length ? '' : 'Es necesario el articulo del post',
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
		},
		mounted() {
			this.obtenerArticulo()
		},
};
</script>
