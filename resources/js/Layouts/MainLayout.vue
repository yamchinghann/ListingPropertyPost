<template>
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.index')">Listings</Link>
                </div>
                <div class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center">
                    <Link :href="route('listing.index')">LaraZillow</Link>
                </div>
                <div v-if="user" class="flex items-center gap-4">
                    <Link class="text-gray-500 relative pr-2 py-2 text-lg"
                          :href="route('notification.index')"
                    >
                        🔔
                        <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
                            {{ notificationCount }}
                        </div>
                    </Link>

                    <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">{{ user.name }}</Link>
                    <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
                    <div>
                        <Link :href="route('logout')" method="DELETE" as="button">Logout</Link>
                    </div>
                </div>
                <div v-else class="flex items-center gap-2">
                    <Link :href="route('user-account.create')">Register</Link>
                    <Link :href="route('login')">Sign-In</Link>
                </div>
            </nav>
        </div>
    </header>
<!--    <div>The page with time {{ timer }}</div>-->
    <main class="container mx-auto p-4 w-full">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
            {{ flashSuccess }}
        </div>
        <slot>Default Content</slot> <!--if nothing pass from parent then display default slot content-->
    </main>

<!--    <div>
        {{ y }}
    </div>-->
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
/*const timer = ref(0);
setInterval(() => timer.value++, 1000)*!/*/
//page.props.value.flash.success ***why flash.success because we create an array in HandleInertiaRequest

//We also know that the easy way to pass such data to all the pages is through special handler inertia
//requests, Laravel Middleware **Inertia Laravel Middleware 's share method at HandleInertiaRequest.php.
//So everything you add here will be passed and available in all Vue pages in all view components.
//page.props.value.flash.success
const page = usePage()
const flashSuccess = computed(
    () => page.props.flash.success,
)
const user = computed(
    () => page.props.user,
)

const notificationCount = computed(
    () => Math.min(page.props.user.notificationCount, 9),//if more than 9 then it will take 9
)
/*const x = ref(0); //if ref here got any update then below computed will recalculate
const y = computed(() => x.value * 2);*/
</script>

<style scoped>
</style>
