<template>
  <div id="app" class="container mt-5">
    <form @submit.prevent="create">
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          v-model="newUserGroup.name"
          type="text"
          class="form-control"
          id="name"
          required
        />
        <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
      </div>

      <div class="form-group">
        <label for="description">Description:</label>
        <textarea
          v-model="newUserGroup.description"
          class="form-control"
          id="description"
          rows="3"
        ></textarea>
        <p class="text-danger" v-if="errors.description">
          {{ errors.description[0] }}
        </p>
      </div>

      <div class="form-group" v-if="users">
        <label for="selectUsers">Select Users:</label>
        <select
          class="form-control"
          v-model="newUserGroup.userIds"
          name="userIds"
          id="userIds"
        >
          <option value="0">Select user</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.email }}
          </option>
        </select>
        <!-- <select
          v-model="newUserGroup.userIds"
          multiple
          class="form-control"
          id="userIds"
          name="userIds"
          required
        >
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.email }}
          </option>
        </select> -->
        <p class="text-danger" v-if="errors.userIds">{{ errors.userIds[0] }}</p>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>
<script>
import router from "../../router";
export default {
  data() {
    return {
      newUserGroup: {
        name: "",
        description: "",
        userIds: "",
      },
      users: "",
      errors: "",
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    async create() {
      await axios
        .post("/api/usergroup", this.newUserGroup)
        .then((response) => {
          router.push({ name: "UserGroupList" });
        })
        .catch((error) => {
          this.errors = error.response.data.message;
          console.log(error);
        });
    },
    async getUsers() {
      await axios
        .get("/api/getUsersWithSpecifiedGroupId")
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.users = [];
        });
    },
  },
};
</script>
<style>
</style>