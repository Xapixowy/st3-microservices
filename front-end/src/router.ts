import {createWebHistory, createRouter, RouteRecordRaw, Router} from "vue-router";
import AuthService from "@/services/AuthService.ts";

const routes  = [
    { path: '/', name: 'Home', component: () =>import('@views/HomeView.vue') },
    { path: '/login', name: 'Login', component: () => import('@views/LoginView.vue') },
    { path: '/register', name: 'Register', component: () => import('@views/RegisterView.vue') },
    {
        path: '/hotels',
        name: 'HotelsList',
        children: [
            {
                path: '',
                name: 'Hotels',
                component: () => import('@views/HotelsListView.vue')
            },
            {
                path: 'create',
                name: 'HotelCreate',
                component: () => import('@views/HotelCreateView.vue')
            },
            {
                path: ':id/edit',
                name: 'HotelEdit',
                component: () => import('@views/HotelEditView.vue'),
                props: true
            },
            {
                path: ':hotelId/rooms',
                name: 'HotelRooms',
                component: () => import('@views/RoomsListView.vue'),
                props: true
            },
            {
                path: ':hotelId/rooms/create',
                name: 'HotelRoomCreate',
                component: () => import('@views/RoomCreateView.vue'),
                props: true
            },
            {
                path: ':hotelId/rooms/:roomId/edit',
                name: 'HotelRoomEdit',
                component: () => import('@views/RoomEditView.vue'),
                props: true
            }
        ]
    },
    {
        path: '/restaurants',
        name: 'Restaurants',
        children: [
            {
                path: '',
                name: 'Restaurants',
                component: () => import('@views/RestaurantsListView.vue')
            },
            {
                path: 'create',
                name: 'RestaurantCreate',
                component: () => import('@views/RestaurantCreateView.vue')
            },
            {
                path: ':id/edit',
                name: 'RestaurantEdit',
                component: () => import('@views/RestaurantEditView.vue'),
                props: true
            },
            {
                path: ':restaurantId/tables',
                name: 'RestaurantTables',
                component: () => import('@views/TablesList.vue'),
                props: true,
            },
            {
                path: ':restaurantId/tables/create',
                name: 'RestaurantTableCreate',
                component: () => import('@views/TableCreateView.vue'),
                props: true,
            },
            {
                path: ':restaurantId/tables/:tableId/edit',
                name: 'RestaurantTableEdit',
                component: () => import('@views/TableEditView.vue'),
                props: true,
            }
        ]
    },
    {
        path: '/reservations',
        name: 'Reservations',
        children: [
            {
                path: '',
                name: 'Reservations',
                component: () => import('@views/ReservationsListView.vue')
            },
            {
                path: 'create',
                name: 'ReservationCreate',
                component: () => import('@views/ReservationCreateView.vue')
            },
            {
                path: ':id/edit',
                name: 'ReservationEdit',
                component: () => import('@views/ReservationEditView.vue'),
                props: true
            }

        ]
    },
]

const router: Router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if ((to.path !== '/login' && to.path !== '/register') && !AuthService.isLoggedIn()) {
        next('/login')
    } else {
        next()
    }
})

export default router;
