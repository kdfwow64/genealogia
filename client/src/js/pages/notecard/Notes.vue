<template>
    <div class="notes-wrapper">
        <div class="field is-grouped">
            <slot name="controls"
                :create="create"
                :internal-query="internalQuery"
                :fetch="fetch">
                <p class="control">
                    <a class="button is-small is-info is-rounded is-bold"
                        @click="create()">
                        <span>
                            {{ i18n('New Note') }}
                        </span>
                        <span class="icon">
                            <fa icon="plus"/>
                        </span>
                    </a>
                </p>
                <p class="control has-icons-left has-icons-right is-expanded">
                    <input class="input is-rounded is-small"
                        v-model="internalQuery"
                        :placeholder="i18n('Filter')">
                    <span class="icon is-small is-left">
                        <fa icon="search"/>
                    </span>
                    <span class="icon is-small is-right clear-button"
                        @click="internalQuery = ''"
                        v-if="internalQuery">
                        <a class="delete is-small"/>
                    </span>
                </p>
                <p class="control">
                    <a class="button is-small is-rounded is-bold"
                        @click="fetch()">
                        <span>
                            {{ i18n('Reload') }}
                        </span>
                        <span class="icon">
                            <fa icon="sync"/>
                        </span>
                    </a>
                </p>
            </slot>
        </div>
        <div class="columns is-multiline has-margin-top-large">
            <div class="column is-half-tablet"
                v-for="(note, index) in filteredNotes"
                :key="index">
                <note-card :note="note"
                    @make-default="make('default', note)"
                    @edit="edit(note)"
                    @delete="destroy(note, index)"/>
            </div>
        </div>
        <note-form :path="path"
            :id="id"
            :type="type"
            @close="path = null"
            @submit="fetch(); path = null;"
            v-if="path"/>
    </div>
</template>

<script>
import { faPlus, faSync, faSearch } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import NoteCard from './NoteCard.vue';
import NoteForm from './NoteForm.vue';

library.add(faPlus, faSync, faSearch);

export default {
    name: 'Notes',

    components: { NoteCard, NoteForm },

    inject: ['errorHandler', 'i18n', 'route'],

    props: {
        id: {
            type: [String, Number],
            required: true,
        },
        type: {
            type: String,
            default: null,
        },
        query: {
            type: String,
            default: '',
        },
    },

    data: () => ({
        loading: false,
        notes: [],
        path: null,
        internalQuery: '',
    }),

    computed: {
        filteredNotes() {
            const query = this.internalQuery.toLowerCase();

            return query
                ? this.notes.filter(
                    ({ city, street }) => city.toLowerCase().indexOf(query) > -1
                        || street.toLowerCase().indexOf(query) > -1,
                )
                : this.notes;
        },
        count() {
            return this.filteredNotes.length;
        },
        params() {
            return {
                noteable_id: this.id,
                noteable_type: this.type,
            };
        },
    },

    watch: {
        query() {
            this.internalQuery = this.query;
        },
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get(this.route('core.notes.index'), { params: this.params })
                .then(({ data }) => {
                    this.notes = data;
                    this.$emit('update');
                    this.loading = false;
                }).catch(this.errorHandler);
        },
        edit(note) {
            this.path = this.route('core.notes.edit', note.id);
        },
        create() {
            this.path = this.route('core.notes.create', this.params);
        },
        make(type, note) {
            this.loading = true;
            const method = type.charAt(0).toUpperCase() + type.slice(1);

            axios.patch(this.route(`core.notes.make${method}`, note.id))
                .then(() => this.fetch())
                .catch(this.errorHandler);
        },
        destroy(note, index) {
            this.loading = true;

            axios.delete(this.route('core.notes.destroy', note.id))
                .then(() => {
                    this.notes.splice(index, 1);
                    this.$emit('update');
                    this.loading = false;
                }).catch(this.errorHandler);
        },
    },
};
</script>
