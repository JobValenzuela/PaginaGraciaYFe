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
        icon: "mdi-menu",
      },
    },
  ],
});
// router.beforeEach(async (to, from, next) => {

// });
export default router;
