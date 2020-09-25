<template>
    <div>
        <enso-select-filter
            title="my title"
            :source="route('dna.options')"
            v-model="dnas.id"/>
        <enso-table
            class="box is-paddingless raises-on-hover"
            id="dna_matchings">
            <template v-slot:image="{ row, column }">
                <a
                    :href="'../storage/app/dna/output/' + row[column.name]"
                    target="_blank">
                    <img
                        :src="'../storage/app/dna/output/' + row[column.name]"
                        width="100"
                        height="150">
                </a>
            </template>
            <template v-slot:file1="{ row, column }">
                <a
                    :href="'../storage/app/dna/output/' + row[column.name]"
                    target="_blank">{{ row[column.name] }}</a>
            </template>
            <template v-slot:file2="{ row, column }">
                <a
                    :href="'../storage/app/dna/output/' + row[column.name]"
                    target="_blank">{{ row[column.name] }}</a>
            </template>
        </enso-table>
    </div>
</template>

<script>
import { EnsoTable } from '@enso-ui/bulma';
import { EnsoSelectFilter } from '@enso-ui/filters/bulma';

export default {
    name: 'Index',

    components: { EnsoTable, EnsoSelectFilter },
};
</script>

<style lang="scss"></style>
