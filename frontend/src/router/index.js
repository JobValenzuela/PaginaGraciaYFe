import { createRouter, createWebHashHistory } from "vue-router";
import UserStore from "@/stores/UserStore";

const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/login",
      name: "login",
      component: () => import("../views/Login.vue"),
      meta: {
        icon: "mdi-login", // Icono de inicio de sesión
        nombrePublico: 'Iniciar Sesión',
        isAuth: false, // No requiere autenticación
      },
    },
    {
      path: "/Dashboard",
      name: "Dashboard",
      component: () => import("../views/Dashboard.vue"),
      meta: {
        icon: "mdi-view-dashboard", // Icono de Dashboard
        nombrePublico: 'Inicio',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Miembros",
      name: "Miembros",
      component: () => import("../views/Miembros.vue"),
      meta: {
        icon: "mdi-account-group", // Icono de grupo de personas
        nombrePublico: 'Miembros',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Catalogo/Ministerios",
      name: "catalogo-ministerios",
      component: () => import("../views/CatalogoMinisterios.vue"),
      meta: {
        icon: "mdi-library-shelves", // Icono de estanterías para catálogos
        nombrePublico: 'Catálogo de ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Lideres/Ministerios",
      name: "Lideres-ministerios",
      component: () => import("../views/LideresMinisterios.vue"),
      meta: {
        icon: "mdi-account-star", // Icono de líderes
        nombrePublico: 'Líderes de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Participantes/Ministerios",
      name: "Participantes-ministerios",
      component: () => import("../views/ParticipantesMinisterios.vue"),
      meta: {
        icon: "mdi-account-multiple-check", // Icono de participantes
        nombrePublico: 'Participantes de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Eventos",
      name: "Eventos",
      component: () => import("../views/Eventos.vue"),
      meta: {
        icon: "mdi-calendar-multiple", // Icono de eventos o calendario
        nombrePublico: 'Eventos',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Familias",
      name: "Familias",
      component: () => import("../views/Familias.vue"),
      meta: {
        icon: "mdi-home-group", // Icono de familias o grupo familiar
        nombrePublico: 'Familias',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/consejerias",
      name: "Consejerias",
      component: () => import("../views/Consejerias.vue"),
      meta: {
        icon: "mdi-human-greeting-variant", // Icono de consejería o ayuda
        nombrePublico: 'Consejerías',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/ingresos-egresos",
      name: "IngresosEgresos",
      component: () => import("../views/IngresosEgresos.vue"),
      meta: {
        icon: "mdi-cash-register", // Icono de ingresos y egresos
        nombrePublico: 'Ingresos y egresos',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/mobiliario",
      name: "Mobiliario",
      component: () => import("../views/Mobiliario.vue"),
      meta: {
        icon: "mdi-sofa", // Icono de mobiliario
        nombrePublico: 'Mobiliario',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/peticiones-oracion",
      name: "PeticionesOracion",
      component: () => import("../views/PeticionesOracion.vue"),
      meta: {
        icon: "mdi-hands-pray", // Icono de manos en oración
        nombrePublico: 'Peticiones de oración',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/visitantes",
      name: "Visitantes",
      component: () => import("../views/Visitantes.vue"),
      meta: {
        icon: "mdi-account-question", // Icono de visitantes
        nombrePublico: 'Visitantes',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Usuarios",
      name: "UsuariosyPermisos",
      component: () => import("../views/UsuariosyPermisos.vue"),
      meta: {
        icon: "mdi-shield-account", // Icono de usuarios con permisos
        nombrePublico: 'Usuarios y permisos',
        isAuth: true, // Requiere autenticación
      },
    },
  ],
});

// router.beforeEach(()=>{
//   return router
// })

export default router;
