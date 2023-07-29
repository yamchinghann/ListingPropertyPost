<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import {Link} from "@inertiajs/vue3";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import {useMonthlyPayment} from "@/Composables/useMonthly.js";

const props = defineProps({listing: Object})
const { monthlyPayment } = useMonthlyPayment(
    props.listing.price, 2.5, 25,
)
</script>

<template>
    <Box>
        <div>
            <!--            <Link :href="`/listing/${listing.id}`">-->
            <Link :href="route('listing.show', {listing: listing.id})">
                <div class="flex items-center gap-1">
                    <Price
                        :price="listing.price"
                        class="text-2xl font-bold"
                    />
                    <div class="text-xs text-gray-500">
                        <Price :price="monthlyPayment" /> pm
                    </div>
                </div>
                <ListingSpace :listing="listing" class="text-lg"/><!--remember use non-props attr, the file must have only one root element-->
                <ListingAddress :listing="listing" class="text-gray-500"/>
            </Link>
            <!--            </Link>-->
        </div>
<!--        <div>
            <Link :href="route('listing.destroy', {listing: listing.id})" method="DELETE" as="button">Delete</Link>
            &lt;!&ndash;            //normally we have to html form to state HTML method then we are able to perform CRUD&ndash;&gt;
        </div>-->
    </Box>
</template>

<style scoped>

</style>
