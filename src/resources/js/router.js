import { createRouter, createWebHistory } from "vue-router";
import Task from "./Task/Index.vue";
import Show from "./Task/Show.vue";

const routes = [
  {
    path: "/tasks",
    name: "tasks",
    component: Task,
  },
  {
    path: "/tasks/:id",
    name: "show",
    component: Show,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
