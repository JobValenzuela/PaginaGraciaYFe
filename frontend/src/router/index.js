import { createRouter, createWebHashHistory } from "vue-router";
import UserStore from "@/stores/UserStore";
const router = createRouter({
  history: createWebHashHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/user",
      name: "user-dashboard",
      component: () => import("../views/userDashboard.vue"),
      meta: {
        isAdmin: false,
        isAuth: true,
      },
    },
    {
      path: "/admin",
      name: "admin-dashboard",
      component: () => import("../views/adminDashboard.vue"),
      meta: {
        isAdmin: true,
        isAuth: true,
      },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/Login.vue"),
      meta: {
        isAdmin: false,
        isAuth: false,
      },
    },
  ],
});
router.beforeEach(async (to, from, next) => {
  const userStore = UserStore();
  // if(!userStore.user.isLogged){router.push({ name: 'login' })}
  // if (userStore.user.isLogged && ["login"].includes(to.name)) {
  //   if (userStore.user.admin) return next({ name: "admin-dashboard" });
  //   else return next({ name: "user-dashboard" });
  // }
  // if (to.meta.isAuth && userStore.user.isLogged) {
  //   if (to.meta.isAdmin && userStore.user.isAdmin) {
  //     next();
  //   } else if (!to.meta.isAdmin && !userStore.user.isAdmin) {
  //     next();
  //   } else if (userStore.user.isAdmin) {
  //     return next({ name: "admin-dashboard" }, () => {});
  //   } else if (!userStore.user.isAdmin) {
  //     return next({ name: "user-dashboard" }, () => {});
  //   } else {
  //     next({ name: "login" }, () => {});
  //   }
  // }
  next();
});
export default router;
