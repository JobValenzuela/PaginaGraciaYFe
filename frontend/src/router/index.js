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
        icon: "mdi-login",
        nombrePublico: 'Iniciar Sesion',
        isAuth: false, // No requiere autenticación
      },
    },
    {
      path: "/Dashboard",
      name: "Dashboard",
      component: () => import("../views/Dashboard.vue"),
      meta: {
        icon: "mdi-view-dashboard",
        nombrePublico: 'Inicio',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Miembros",
      name: "Miembros",
      component: () => import("../views/Miembros.vue"),
      meta: {
        icon: "mdi-account-group",
        nombrePublico: 'Miembros',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Catalogo/Ministerios",
      name: "catalogo-ministerios",
      component: () => import("../views/CatalogoMinisterios.vue"),
      meta: {
        icon: "mdi-church",
        nombrePublico: 'Catalogo de ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Lideres/Ministerios",
      name: "Lideres-ministerios",
      component: () => import("../views/LideresMinisterios.vue"),
      meta: {
        icon: "mdi-account-tie-outline",
        nombrePublico: 'Lideres de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Participantes/Ministerios",
      name: "Participantes-ministerios",
      component: () => import("../views/ParticipantesMinisterios.vue"),
      meta: {
        icon: "mdi-account-tie-outline",
        nombrePublico: 'Participantes de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Usuarios",
      name: "UsuariosyPermisos",
      component: () => import("../views/Usuarios.vue"),
      meta: {
        icon: "mdi-account-cog",
        nombrePublico: 'Usuarios y permisos',
        isAuth: true, // Requiere autenticación
      },
    },
  ],
});

export default router;
