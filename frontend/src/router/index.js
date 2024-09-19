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
        icon: "mdi-login", // Mantiene el icono de login
        nombrePublico: 'Iniciar Sesión',
        isAuth: false, // No requiere autenticación
      },
    },
    {
      path: "/Dashboard",
      name: "Dashboard",
      component: () => import("../views/Dashboard.vue"),
      meta: {
        icon: "mdi-view-dashboard-outline", // Icono de Dashboard
        nombrePublico: 'Inicio',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Miembros",
      name: "Miembros",
      component: () => import("../views/Miembros.vue"),
      meta: {
        icon: "mdi-account-multiple-outline", // Grupo de personas
        nombrePublico: 'Miembros',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Catalogo/Ministerios",
      name: "catalogo-ministerios",
      component: () => import("../views/CatalogoMinisterios.vue"),
      meta: {
        icon: "mdi-book-open-outline", // Catálogo o lista abierta
        nombrePublico: 'Catálogo de ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Lideres/Ministerios",
      name: "Lideres-ministerios",
      component: () => import("../views/LideresMinisterios.vue"),
      meta: {
        icon: "mdi-account-star-outline", // Icono de líderes o figuras destacadas
        nombrePublico: 'Líderes de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Participantes/Ministerios",
      name: "Participantes-ministerios",
      component: () => import("../views/ParticipantesMinisterios.vue"),
      meta: {
        icon: "mdi-account-multiple-check", // Icono de participantes o miembros seleccionados
        nombrePublico: 'Participantes de los ministerios',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Eventos",
      name: "Eventos",
      component: () => import("../views/Eventos.vue"),
      meta: {
        icon: "mdi-calendar-multiple-check", // Icono de eventos o calendario
        nombrePublico: 'Eventos',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Familias",
      name: "Familias",
      component: () => import("../views/Familias.vue"),
      meta: {
        icon: "mdi-account-key-outline", // Icono de usuarios con permisos
        nombrePublico: 'Familias',
        isAuth: true, // Requiere autenticación
      },
    },
    {
      path: "/Usuarios",
      name: "UsuariosyPermisos",
      component: () => import("../views/Usuarios.vue"),
      meta: {
        icon: "mdi-account-key-outline", // Icono de usuarios con permisos
        nombrePublico: 'Usuarios y permisos',
        isAuth: true, // Requiere autenticación
      },
    },
  ],
});

export default router;
