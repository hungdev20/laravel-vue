<template>
  <div class="container">
    <h1 class="mt-2">Update User</h1>
    <form @submit.prevent="updateUser">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          v-model="user.username"
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
          v-model="user.firstName"
          required
        />
      </div>
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name</label>
        <input
          type="text"
          class="form-control"
          id="lastName"
          v-model="user.lastName"
          required
        />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          v-model="user.email"
          required
        />
      </div>
      <div class="mb-3">
        <label for="selectUsergroup">Select Usergroup:</label>
        <select
          class="form-control"
          v-model="user.groupId"
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
        <input type="password" class="form-control" id="password" required />
      </div>
      <button
        type="submit"
        class="btn btn-primary"
        @click.prevent="updateUser(user)"
      >
        Update User
      </button>
    </form>
  </div>
</template>
<script>
import { computed, onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

export default {
  setup() {
    const route = useRoute();
    const store = useStore();
    const usergroups = ref([]);
    onMounted(() => {
      const id = route.params.id;
      store.dispatch("showUser", id);
      getUserGroups(id);
    });
    const errors = computed(() => store.getters.errors);
    const user = computed(() => store.getters.user);
    const updateUser = (user) => {
      store.dispatch("updateUser", user);
    };
    const getUserGroups = async (id) => {
      await axios
        .get(`/api/getUsergroupsWithSpecifiedId/${id}`)
        .then((response) => {
          usergroups.value = response.data;
        })
        .catch((error) => {
          console.log(error);
          usergroups.value = [];
        });
    };
    return {
      user,
      usergroups,
      errors,
      updateUser,
    };
  },
};
</script>
  <style>
</style>