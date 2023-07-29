<script setup>
import {computed, reactive, watch} from "vue";
import {debounce} from 'lodash'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    filters: Object,
})
const sortLabels = {
    created_at: [{label: 'Latest', value: 'desc'}, {label: 'Oldest', value: 'asc'}],
    price: [{label: 'Pricey', value: 'desc'}, {label: 'Cheapest', value: 'asc'}]
}
//console.log(sortLabels['created_at'].map((orderItem) => orderItem.label + " = " + orderItem.value))
const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'desc',
})

const sortOptions = computed(()=> sortLabels[filterForm.by])

// reactive / ref / computed
watch(
    filterForm, debounce(() => router.get(
        route('realtor.listing.index'),
        filterForm,
        {preserveState: true, preserveScroll: true},
    ), 1000),
)

//Lesson of Watch
//watch(filterForm, ()=> console.log('Change was detected'))//this cannot see it's what value was changed, so need use getter method
//watch(()=> filterForm.deleted, (newValue, oldValue)=> console.log(newValue, oldValue), {deep: true}) //here able to see what the different between new and old valie
//Array
//watch([()=> filterForm.deleted, ()=> filterForm.xxx], (newValue, oldValue)=> console.log(newValue, oldValue), {deep: true})
</script>

<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-4">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    id="deleted"
                    v-model="filterForm.deleted"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="deleted">Deleted</label>
            </div>
            <div>
              <select class="input-filter-l w-24" v-model="filterForm.by">
                  <option value="created_at">Added</option>
                  <option value="price">Price</option>
              </select>
                <select class="input-filter-r w-32" v-model="filterForm.order">
                    <option v-for="option in sortOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
