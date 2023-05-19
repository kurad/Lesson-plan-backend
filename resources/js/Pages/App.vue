<template>
    <div>
        <ul class="navbar-nav">
            <template v-if="isLoggedIn">
                <div v-for="role in user.roles" :key="role.id">
                    <li class="nav-item">
                        <router-link :to="{name: role.name}" class="nav-link">{{role.name}}</router-link>
                    </li>
                </div>
                <li class="nav-item"><span class="nav-link" @click="logout">Logout</span></li>
            </template>
            <template v-if="!isLoggedIn">
                <li class="nav-item">
                    <router-link :to="{name: 'login'}" class="nav-link">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'register'}" class="nav-link">Register</router-link>
                </li>
            </template>
        </ul>

        <main class="container-fluid py-4">
            <router-view @loggedIn="setUser"></router-view>
        </main>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: null,
            isLoggedIn: false
        }
    },
    mounted() {
        this.setUser()
    },
    methods: {
        setUser() {
            this.user = JSON.parse(localStorage.getItem('user'))
            this.isLoggedIn = localStorage.getItem('token') != null

        },
        logout() {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            this.setUser()

            this.$router.push('/')
        }
    }
}
</script>
