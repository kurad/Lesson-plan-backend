import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue';
import Home from '../components/Home.vue';
import Register from '../components/Register.vue';
import Admin from '../components/Admin.vue';
import Teacher from '../components/Teacher.vue';
import Dos from '../components/Dos.vue';


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin,
        meta: {
            requiresAuth: true,
            isAdmin: true
        }
    },
    {
        path: '/dos',
        name: 'dos',
        component: Dos,
        meta: {
            requiresAuth: true,
            isDean: true
        }
    },
    {
        path: '/teacher',
        name: 'teacher',
        component: Teacher,
        meta: {
            requiresAuth: true,
            isTeacher: true
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


export default router

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let token = localStorage.getItem('token') != null;
        if (!token) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('user'))
            let roles = user.roles.map(role => role.name)
            console.log(roles[0]);
            if (to.matched.some(record => record.meta.isTeacher)) {
                if (roles.includes('Teacher')) next()
                else if (roles[0] === 'Admin') {
                    next({
                        name: 'admin'
                    })
                } else if (roles[0] === 'Dean of Academics') {
                    next({
                        name: 'dos'
                    })
                } else next({
                    name: 'home'
                })
            } else if (to.matched.some(record => record.meta.isAdmin)) {
                if (roles.includes('Admin')) next()
                else if (roles[0] === 'Teacher') {
                    next({
                        name: 'teacher'
                    })
                } else if (roles[0] === 'Dean of Academics') {
                    next({
                        name: 'dos'
                    })
                } else next({
                    name: 'home'
                })

            } else if (to.matched.some(record => record.meta.isDean)) {
                if (roles.includes('Dean of Academics')) next()
                else if (roles[0] === 'Teacher') {
                    next({
                        name: 'teacher'
                    })
                } else if (roles[0] === 'Admin') {
                    next({
                        name: 'admin'
                    })
                } else next({
                    name: 'home'
                })

            } else {
                next()
            }
        }
    } else {
        next()
    }
})
