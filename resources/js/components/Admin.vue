<template>
    <div>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-white bg-dark rounded-3">
                    <h1>Dashboard, Admin.</h1>
                    <label>Login sebagai:</label>
                    <h2>{{loginType}}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <p>Peran yang dimiliki:</p>
                    <ul v-for="role in user.roles" :key="role.id">
                        <li> {{ role.name }} {{ role.user.name}} </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            user: '',
            loginType: ''
        }
    },
    created() {
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')

        axios.get(`/api/user`)
            .then(response => {
                this.user = response.data
                this.loginType = response.data.roles[0].name
            })
            .catch(error => {
                if (error.response.status === 401) {
                    localStorage.clear();
                    this.$router.push('/login')
                }
                console.error(error);
            })
    }
}
</script>
  