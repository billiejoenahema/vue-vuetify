<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const constants = ref([]);
const task = ref("");
const tasks = ref([]);
const searchTitle = ref("");
const priorityTextValue = (priority) => {
  const priorityText = constants.value.priorities.find(
    (p) => p.value === priority
  );
  return priorityText ? priorityText.text : "";
};

onMounted(() => {
  getTasks();
  getConstants();
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
  };
  const res = await axios.get("/api/tasks", { params });
  tasks.value = res.data;
};
// 検索ワード削除
const clearSearch = async () => {
  searchTitle.value = "";
  getTasks();
};
// 新規登録
const addTask = async () => {
  const res = await axios.post("/api/tasks", { title: task.value, done: 0 });
  tasks.value.unshift(res.data);
  task.value = "";
};
// 削除
const deleteTask = async (id) => {
  await axios.delete("/api/tasks/" + id);
  tasks.value = tasks.value.filter((task) => task.id !== id);
};
// 詳細ページに移動
const moveTask = (id) => {
  router.push({ name: "show", params: { id: id } });
};
// 完了にする
const doneEffect = (id) => {
  const checkbox = document.getElementById("checkbox-" + id);
  const label = document.getElementById("label-" + id);
  if (checkbox.checked) {
    label.parentElement.style.textDecoration = "line-through";
  } else {
    label.parentElement.style.textDecoration = "none";
  }
};
</script>
<template>
  <v-main>
    <v-card class="mx-auto mt-16" width="600">
      <v-toolbar color="purple">
        <v-toolbar-title>Todo Card</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-text-field
          label="タスク検索"
          variant="outlined"
          class="w-25"
          hide-details
          density="compact"
          clearable
          v-model="searchTitle"
        ></v-text-field>
        <v-btn icon="mdi-magnify" @click="searchTask"></v-btn>
        <v-btn icon="mdi-close" @click="clearSearch"></v-btn>
      </v-toolbar>

      <v-form @submit.prevent="addTask">
        <v-text-field
          label="タスク追加"
          clearable
          v-model="task"
        ></v-text-field>
      </v-form>

      <v-list lines="three" select-strategy="classic">
        <v-list-subheader>タスク一覧</v-list-subheader>
        <v-checkbox
          v-for="task in tasks"
          :key="task.id"
          :label="task.title"
          @change="doneEffect(task.id)"
          :id="'checkbox-' + task.id"
        >
          <template v-slot:label>
            <div :id="'label-' + task.id">{{ task.title }}</div>
            <div :id="'priority-' + task.id" class="priority">
              【{{ priorityTextValue(task.priority) }}】
            </div>
          </template>
          <template v-slot:append>
            <v-icon
              class="mr-6 cursor-pointer"
              title="編集"
              @click="moveTask(task.id)"
              >mdi-file-document-edit</v-icon
            >
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
