<template>
    <form @submit.prevent="create">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-2">
                <label class="label">Beds</label>
                <input v-model.number="form.beds" type="text" class="input"/>
                <InputError :input-error="form.errors.beds" />
            </div>

            <div class="col-span-2">
                <label class="label">Baths</label>
                <input v-model.number="form.baths" type="text" class="input"/>
                <InputError :input-error="form.errors.baths" />
            </div>

            <div class="col-span-2">
                <label class="label">Area</label>
                <input v-model.number="form.area" type="text" class="input"/>
                <InputError :input-error="form.errors.area" />
            </div>

            <div class="col-span-4">
                <label class="label">City</label>
                <input v-model="form.city" type="text" class="input"/>
                <InputError :input-error="form.errors.city" />
            </div>

            <div class="col-span-2">
                <label class="label">Post Code</label>
                <input v-model="form.code" type="text" class="input"/>
                <InputError :input-error="form.errors.code" />
            </div>

            <div class="col-span-4">
                <label class="label">Street</label>
                <input v-model="form.street" type="text" class="input"/>
                <InputError :input-error="form.errors.street" />
            </div>

            <div class="col-span-2">
                <label class="label">Street Nr</label>
                <input v-model.number="form.street_nr" type="text" class="input"/>
                <InputError :input-error="form.errors.street_nr" />
            </div>

            <div class="col-span-6">
                <label class="label">Price</label>
                <input v-model.number="form.price" type="text" class="input"/>
                <InputError :input-error="form.errors.price" />
            </div>

            <div class="col-span-6">
                <button type="submit" class="btn-primary">
                    Create
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
// import {reactive} from "vue";
// import { Inertia } from '@inertiajs/inertia';
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

/*const form = reactive({  //ref is mostly useful for single values like numbers, string or boolean but reactive is used for object
    beds: 0,
    baths: 0,
    area: 0,
    city: null,
    street: null,
    code: null,
    street_nr: null,
    price: 0,
})*/
const form = useForm({  //ref is mostly useful for single values like numbers, string or boolean but reactive is used for object
    beds: 0,
    baths: 0,
    area: 0,
    city: null,
    street: null,
    code: null,
    street_nr: null,
    price: 0,
}) //So if you use this use form, then this form object has an errors field which
// can potentially contain some errors for every field that you submit.

// const create = () => Inertia.post('/listing', form); //first p: url, second p: argument**use to send to backend

//const create = () => form.post('/listing'); //it similar to above but it more simpler
const create = () => form.post(route('realtor.listing.store'));
//form.beds// they are reactive when you read them or when you set them.
// So they might cause the UI to update or some other values that depend on them to change.

//const x = form.beds
//But once you set a new variable based on this reactive property, read from the form variable, this
// x is no longer reactive.

//Summary of Ref vs Reactive
/*So what this means is that all the properties of this object are reactive as long as you access them
using the original object. **E.g: form.beds
So there is this proxy object wrapper around the original object, but the reactivity is lost once you
set it to a different variable.  **E.g: const x = form.beds
*/

/*When to use them?
* So I think you should always default to ref.It's more versatile
* reactive should mostly be used to objects where you have a bigger object with a lot of properties.
* */

</script>

