<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const task = ref("");

onMounted(() => {
  getTask();
});

// 1件取得
const getTask = async () => {
  const id = router.currentRoute.value.params.id;
  const res = await axios.get("/api/tasks/" + id);
  task.value = res.data;
};
// 更新
const updateTask = async (id) => {
  await axios.patch("/api/tasks/" + id, task.value);
  moveTasks();
};
// 一覧へ移動
const moveTasks = () => {
  router.push({ name: "tasks" });
};
</script>

<template>
  <v-main>
    <v-container>
      <v-card
        class="mx-auto my-8 py-6"
        elevation="16"
        width="400"
        variant="outlined"
      >
        <v-form @submit.prevent="updateTask(task.id)">
          <v-card-item>
            <v-card-title>
              <v-text-field label="タスク名" clearable v-model="task.title">
              </v-text-field>
            </v-card-title>
          </v-card-item>

          <v-card-item>
            <v-textarea
              label="タスクの説明"
              clearable
              v-model="task.description"
            >
            </v-textarea>
          </v-card-item>

          <v-card-actions>
            <v-btn color="purple-accent-4" variant="text" @click="moveTasks"
              >戻る</v-btn
            >
            <v-btn color="purple-accent-4" variant="outlined" type="submit"
              >更新</v-btn
            >
          </v-card-actions>
        </v-form>
      </v-card>
    </v-container>
  </v-main>
</template>
