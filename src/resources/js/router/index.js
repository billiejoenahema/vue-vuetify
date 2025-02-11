import TaskEdit from "@/views/Task/Edit.vue";
import TaskIndex from "@/views/Task/Index.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "task-index",
    component: TaskIndex,
  },
  {
    path: "/:id",
    name: "task-edit",
    component: TaskEdit,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
