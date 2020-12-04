<template>
		<div class="row">
			<div class="col-sm-12">
				<button type="button" class="btn btn-primary float-right" @click="addlike">{{ articulo.likes }} Me gusta 👍</button>
			</div>

			<div class="col-sm-12">
				<div class="card mt-2" v-for="comentario in comentarios" :key="comentario.id">
					<div class="card-body">
						<h4>{{ comentario.propietario }} <small>, dijo:</small></h4>
						<p v-html="comentario.comentario"></p>
						<small class="float-right">{{ formatDate(comentario.created_at) }}</small>
					</div>
				</div>
			</div>

			<div class="col-sm-12 mt-2">
				<div class="card">
					<div class="card-body">
						<h3>Agrega un nuevo comentario</h3>
						<div class="form-group">
							<label for="autorComentario">Nombre o username</label>
							<input type="text" name="autorComentario" id="autorComentario"  class="form-control" :maxlength="50" v-model="autorComentario">
							<small id="helpId" class="text-muted">máximo 50 caracteres ({{autorComentario.length + '/50'}})</small><br>
						</div>
						<div class="form-group ">
							<vue-editor v-model="comentario" :editor-toolbar="barraHerramientas" ></vue-editor>
						</div>
						<button type="button" class="btn btn-primary float-right" @click="guardarComentario">Guardar</button>
					</div>
				</div>
			</div>

		</div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import moment from 'moment'

export default {
		components: {
			VueEditor
		},
		props: ['id'],
		data(){
			return {
				autorComentario: '',
				comentario: '',
				articulo: { likes: 0 },
				comentarios: [],
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
			renderDatosArticulo(){
				axios.get('articulo_comentarios/' + this.id)
					.then(response => {
						this.articulo = response.data
						this.comentarios = this.articulo.comentarios
					})
			},
			addlike(){
				axios.post('update/articulo', {id: this.id, likes: ++this.articulo.likes})
					.then(console.log)
			},
			guardarComentario(){
				if (!this.autorComentario || !this.comentario) {
					this.$swal('Error', 'Su username y su comentario deben contener valores', 'error')
					return;
				}

				axios.post('comentario', {
					propietario: this.autorComentario,
					comentario: this.comentario,
					articulo_id: this.id
				})
					.then(response => {
						let res = response.data
						this.$swal(res.success ? 'Ok' : 'Error', res.message, res.success ? 'success' : 'error')
						this.renderDatosArticulo()
						this.autorComentario = ''
						this.comentario = ''
					})
			},
			formatDate(value){
        if (value) {
          return moment(String(value)).format('DD-MM-YYYY - hh:mm')
        }
      },
		},
		computed: {
		},
		mounted() {
			this.renderDatosArticulo()
		}
};
</script>
