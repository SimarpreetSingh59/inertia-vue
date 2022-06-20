<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a :href="$route('post.index')" class="navbar-brand">Inertia CRUD</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a :href="$route('post.index')" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a :href="$route('post.create')" class="nav-link">Create Post</a>
                    </li>
                </ul>
            </div>

            <div class="navbar-collapse collapse order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" v-if="!user">
                        <a :href="$route('showLoginForm')" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item" v-if="!user">
                        <a :href="$route('showRegisterForm')" class="nav-link">Register</a>
                    </li>
                    <li class="nav-item" v-if="user">
                        <span class="navbar-text" v-if="user">
                            Logged in as {{user.name}}
                        </span>
                        <a :href="$route('logout')" as="button" method="post" class="nav-link logout-link" style="display: inline" type="button">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";

export default {
    name: "AppHeader",
    setup() {
        const user = computed(() => usePage().props.value.auth.user);

        return {
            user
        }
    }
}
</script>