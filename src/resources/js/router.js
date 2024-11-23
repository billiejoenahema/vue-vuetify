import { createRouter, createWebHistory } from "vue-router";
import Show from "./components/Show.vue";
import Task from "./components/Task.vue";

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
