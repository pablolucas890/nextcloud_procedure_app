<template>
	<div id="content" class="app-procedure">
		<AppNavigation>
			<AppNavigationNew v-if="!loading" :text="t('procedure', 'Nova Nota')" :disabled="false"
				button-id="new-procedure-button" button-class="icon-add" @click="newNote" />
			<ul>
				<AppNavigationItem v-for="note in notes" :key="note.id"
					:title="note.title ? note.title : t('procedure', 'Nova Nota')"
					:class="{ active: currentNoteId === note.id }" :loading="note.id === -1 ? true : false"
					:icon="note.id === -1 ? '' : 'icon-file'" @click="openNote(note)">
					<template slot="actions">
						<ActionButton v-if="note.id === -1" icon="icon-close" @click="cancelNewNote(note)">
							{{  t('procedure', 'Cancelar')  }}
						</ActionButton>
						<ActionButton v-else icon="icon-delete" @click="deleteNote(note)">
							{{  t('procedure', 'Deletar')  }}
						</ActionButton>
					</template>
				</AppNavigationItem>
			</ul>
		</AppNavigation>
		<AppContent>
			<div class="general-content">
				<div v-if="currentNote">
					<div class="title-app">
						<h2>{{  t('procedure', 'Crie uma nota no Aplicativo AmoraDev')  }}</h2>
						<img src="./assets/amora.png" alt="amora" width="50">
					</div>
					<label for="title">Titulo da Nota:</label>
					<input ref="title" v-model="currentNote.title" type="text" :disabled="updating">
					<label for="content">Conteudo da Nota:</label>
					<textarea ref="content" v-model="currentNote.content" :disabled="updating" rows="20" />
					<input type="button" class="primary" :value="t('procedure', 'Salvar')"
						:disabled="updating || !savePossible" @click="saveNote">
				</div>
				<div v-else id="emptycontent">
					<div class="icon-clippy" />
					<h2>{{  t('procedure', 'Crie uma nota no Aplicativo AmoraDev')  }}</h2>
				</div>

			</div>
		</AppContent>
	</div>
</template>

<script>
import ActionButton from '@nextcloud/vue/dist/Components/ActionButton'
import AppContent from '@nextcloud/vue/dist/Components/AppContent'
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem'
import AppNavigationNew from '@nextcloud/vue/dist/Components/AppNavigationNew'

import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

export default {
	name: 'App',
	components: {
		ActionButton,
		AppContent,
		AppNavigation,
		AppNavigationItem,
		AppNavigationNew,
	},
	data() {
		return {
			notes: [],
			currentNoteId: null,
			updating: false,
			loading: true,
		}
	},
	computed: {
		/**
		 * Return the currently selected note object
		 * @returns {Object|null}
		 */
		currentNote() {
			if (this.currentNoteId === null) {
				return null
			}
			return this.notes.find((note) => note.id === this.currentNoteId)
		},

		/**
		 * Returns true if a note is selected and its title is not empty
		 * @returns {Boolean}
		 */
		savePossible() {
			return this.currentNote && this.currentNote.title !== ''
		},
	},
	/**
	 * Fetch list of notes when the component is loaded
	 */
	async mounted() {
		try {
			const response = await axios.get(generateUrl('/apps/procedure/notes'))
			this.notes = response.data
		} catch (e) {
			console.error(e)
			showError(t('procedure', 'Could not fetch notes'))
		}
		this.loading = false
	},

	methods: {
		/**
		 * Create a new note and focus the note content field automatically
		 * @param {Object} note Note object
		 */
		openNote(note) {
			if (this.updating) {
				return
			}
			this.currentNoteId = note.id
			this.$nextTick(() => {
				this.$refs.content.focus()
			})
		},
		/**
		 * Action tiggered when clicking the save button
		 * create a new note or save
		 */
		saveNote() {
			if (this.currentNoteId === -1) {
				this.createNote(this.currentNote)
			} else {
				this.updateNote(this.currentNote)
			}
		},
		/**
		 * Create a new note and focus the note content field automatically
		 * The note is not yet saved, therefore an id of -1 is used until it
		 * has been persisted in the backend
		 */
		newNote() {
			if (this.currentNoteId !== -1) {
				this.currentNoteId = -1
				this.notes.push({
					id: -1,
					title: '',
					content: '',
				})
				this.$nextTick(() => {
					this.$refs.title.focus()
				})
			}
		},
		/**
		 * Abort creating a new note
		 */
		cancelNewNote() {
			this.notes.splice(this.notes.findIndex((note) => note.id === -1), 1)
			this.currentNoteId = null
		},
		/**
		 * Create a new note by sending the information to the server
		 * @param {Object} note Note object
		 */
		async createNote(note) {
			this.updating = true
			try {
				const response = await axios.post(generateUrl('/apps/procedure/notes'), note)
				const index = this.notes.findIndex((match) => match.id === this.currentNoteId)
				this.$set(this.notes, index, response.data)
				this.currentNoteId = response.data.id
				showSuccess(t('procedure', 'Nota Criada'))
			} catch (e) {
				console.error(e)
				showError(t('procedure', 'Could not create the note'))
			}
			this.updating = false
		},
		/**
		 * Update an existing note on the server
		 * @param {Object} note Note object
		 */
		async updateNote(note) {
			this.updating = true
			try {
				await axios.put(generateUrl(`/apps/procedure/notes/${note.id}`), note)
				showSuccess(t('procedure', 'Nota Atualizada'))
			} catch (e) {
				console.error(e)
				showError(t('procedure', 'Could not update the note'))
			}
			this.updating = false
		},
		/**
		 * Delete a note, remove it from the frontend and show a hint
		 * @param {Object} note Note object
		 */
		async deleteNote(note) {
			try {
				await axios.delete(generateUrl(`/apps/procedure/notes/${note.id}`))
				this.notes.splice(this.notes.indexOf(note), 1)
				if (this.currentNoteId === note.id) {
					this.currentNoteId = null
				}
				showSuccess(t('procedure', 'Nota Deletada'))
			} catch (e) {
				console.error(e)
				showError(t('procedure', 'Nao foi possivel deletar a nota'))
			}
		},
	},
}
</script>
<style scoped>
#app-content>div {
	width: 100%;
	height: 100%;
	padding: 20px;
	display: flex;
	flex-direction: column;
	flex-grow: 1;
}

input[type='text'] {
	width: 100%;
}

textarea {
	flex-grow: 1;
	width: 100%;
}

.title-app{
	margin-top: 4em;
	text-align: center;
}
.general-content {
	margin-left: 3em;
}
</style>