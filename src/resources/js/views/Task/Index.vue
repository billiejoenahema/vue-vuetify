<script setup>
import Loader from "@/components/Loader.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

const constants = ref({
  priorities: [],
});
const newTask = ref("");
const tasks = ref([
  {
    id: 0,
    title: "",
    priority: 0,
    is_done: false,
  },
]);
const searchTitle = ref("");
const searchPriority = ref("");
const priorityTextValue = (priority) => {
  const priorityText = constants?.value.priorities.find(
    (p) => p.value === priority
  );
  return priorityText ? priorityText.text : "";
};
const isLoading = ref(false);

onMounted(() => {
  isLoading.value = true;
  getConstants();
  getTasks();
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});

// 定数を取得
const getConstants = async () => {
  const res = await axios.get("/api/constants");
  constants.value = res.data;
};

// 一覧を取得
const getTasks = async () => {
  const res = await axios.get("/api/tasks");
  tasks.value = res.data;
};
// 検索
const searchTask = async () => {
  const params = {
    title: searchTitle.value,
    priority: searchPriority.value,
  };
  const res = await axios.get("/api/tasks", { params });
  tasks.value = res.data;
};
// 検索ワード削除
const clearSearch = async () => {
  searchTitle.value = "";
  searchPriority.value = "";
  getTasks();
};
// 新規登録
const addTask = async () => {
  const res = await axios.post("/api/tasks", { title: newTask.value, done: 0 });
  tasks.value.unshift(res.data);
  newTask.value = "";
};
// 削除
const deleteTask = async (id) => {
  await axios.delete("/api/tasks/" + id);
  tasks.value = tasks.value.filter((task) => task.id !== id);
};

// 完了状態の変更
const changeDoneStatus = async (task) => {
  await axios.patch("/api/tasks/" + task.id, task);
  getTasks();
};
</script>

<template>
  <v-main>
    <loader v-if="isLoading" />
    <v-card class="mx-auto mt-16" width="800">
      <v-toolbar color="purple">
        <v-toolbar-title>Todo Card</v-toolbar-title>

        <v-spacer></v-spacer>

        <!-- Enterキー押下でsearchTaskメソッドを呼び出す -->
        <v-text-field
          label="タスク検索"
          variant="outlined"
          class="w-25"
          hide-details
          density="compact"
          @keyup.enter="searchTask"
          v-model="searchTitle"
        ></v-text-field>

        <v-spacer></v-spacer>

        <!-- 優先度で検索 選択値が変更されたら検索実行 -->
        <v-select
          label="優先度"
          v-model="searchPriority"
          :items="constants.priorities"
          item-title="text"
          item-value="value"
          density="compact"
          hide-details
        ></v-select>
        <v-btn icon="mdi-magnify" @click="searchTask"></v-btn>
        <v-btn icon="mdi-close" @click="clearSearch"></v-btn>
      </v-toolbar>

      <v-form @submit.prevent="addTask">
        <v-text-field
          label="タスク追加"
          clearable
          v-model="newTask"
        ></v-text-field>
      </v-form>

      <v-list lines="three" select-strategy="classic">
        <v-list-subheader>タスク一覧</v-list-subheader>
        <v-checkbox
          v-for="task in tasks"
          :key="task.id"
          v-model="task.is_done"
          @change="changeDoneStatus(task)"
          :id="'checkbox-' + task.id"
        >
          <template v-slot:label>
            <div :id="'label-' + task.id">{{ task.title }}</div>
            <div :id="'priority-' + task.id" class="priority">
              【{{ priorityTextValue(task.priority) }}】
            </div>
          </template>
          <template v-slot:append>
            <router-link :to="{ name: 'task-edit', params: { id: task.id } }">
              <v-icon class="mr-6 cursor-pointer" title="編集"
                >mdi-file-document-edit</v-icon
              >
            </router-link>
            <v-icon
              class="mr-6 cursor-pointer"
              title="削除"
              @click="deleteTask(task.id)"
              >mdi-delete</v-icon
            >
          </template>
        </v-checkbox>
      </v-list>
    </v-card>
  </v-main>
</template>
