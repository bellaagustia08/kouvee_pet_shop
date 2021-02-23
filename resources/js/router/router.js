//Vue
import Vue from 'vue'
import VueRouter from 'vue-router'

//View Pengunjung
import AppPengunjung from '../components/pengunjung/AppPengunjung.vue'
import Home from '../components/pengunjung/PengunjungHome.vue'
import JasaService from '../components/pengunjung/PengunjungJS.vue'
import Sparepart from '../components/pengunjung/PengunjungProduk.vue'
import History from '../components/pengunjung/PengunjungHistory.vue'

import ContactUs from '../components/pengunjung/PengunjungContact.vue'


Vue.use(VueRouter)

const routes = [
    {
        path:'/',        
        component: AppPengunjung,
        children:[
            {
                path: 'jasa-service',
                component: JasaService,

            },
            {
                path: 'sparepart',
                component: Sparepart,

            },
            {
                path: 'history',
                component: History,

            },
            {
                path: 'contactus',
                component: ContactUs,

            },
            {
                path: '/',
                component: Home,

            },
            {
                path: 'cariplat',
                name: 'cari-plat',
                component: PengunjungPlat,

            },
            {
                path: 'pengunjungcari',
                name: 'pengunjungcari',
                component: PengunjungCari,

            },
            {

                path:'/login',
                name: 'login',
                component: AdminLogin,
            },
            {

                path:'/logout',
                component: AdminLogout,
            },
            
        ]
    }
]

const router = new VueRouter({
    base: '/P3L/public',
    routes,
    hashbang: false,
    mode: 'history',
});

export default router;
