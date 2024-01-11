<template>
  <div class="container">
    <h1 class="mt-2">Add User</h1>
    <form @submit.prevent="addUser">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          v-model="newUser.username"
          required
        />
        <p class="text-danger" v-if="errors.username">
          {{ errors.username[0] }}
        </p>
      </div>
      <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input
          type="text"
          class="form-control"
          id="firstName"
          v-model="newUser.firstName"
          required
        />
        <p class="text-danger" v-if="errors.firstName">
          {{ errors.firstName[0] }}
        </p>
      </div>
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input
          type="text"
          class="form-control"
          id="lastName"
          v-model="newUser.lastName"
          required
        />
        <p class="text-danger" v-if="errors.lastName">
          {{ errors.lastName[0] }}
        </p>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          v-model="newUser.email"
          required
        />
        <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
      </div>
      <div class="mb-3">
        <label for="selectUsergroup">Select Usergroup:</label>
        <select
          class="form-control"
          v-model="newUser.groupId"
          name="groupId"
          id="groupId"
        >
          <option value="">Select user group</option>
          <option
            v-for="usergroup in usergroups"
            :key="usergroup.id"
            :value="usergroup.id"
          >
            {{ usergroup.name }}
          </option>
        </select>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          v-model="newUser.password"
          required
        />
        <p class="text-danger" v-if="errors.password">
          {{ errors.password[0] }}
        </p>
      </div>
      <button type="submit" class="btn btn-primary" @click.prevent="create">
        Add User
      </button>
    </form>
  </div>
</template>

<script>
import router from "../../router";
export default {
  data() {
    return {
      newUser: {
        username: "",
        firstName: "",
        lastName: "",
        email: "",
        password: "",
        groupId: "",
      },
      usergroups: "",
      errors: "",
    };
  },
  mounted() {
    this.getUserGroups();
  },
  methods: {
    async create() {
      await axios
        .post("/api/user", this.newUser)
        .then((response) => {
          if (response.data.success) {
            router.push({ name: "UserList" });
          } else {
            this.errors = response.data.message;
          }
        })
        .catch((error) => {
          this.errors = error.response.data.message;
          console.log(error);
        });
    },
    async getUserGroups() {
      await axios
        .get("/api/getUsergroupsWithSpecifiedId")
        .then((response) => {
          this.usergroups = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.usergroups = [];
        });
    },
  },
};
</script>

<style>
</style>