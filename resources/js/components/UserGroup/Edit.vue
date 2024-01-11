<template>
  <div id="app" class="container mt-5">
    <h1 class="mt-2">Update Usergroup</h1>
    <form @submit.prevent="updateUsergroup(usergroup.id)">
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          v-model="usergroup.name"
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
          v-model="usergroup.description"
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
          v-model="usergroup.userIds"
          name="userIds"
          id="userIds"
          required
        >
          <option value="0">Select user</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.email }}
          </option>
        </select>
        <!-- <select
          v-model="usergroup.userIds"
          multiple
          class="form-control"
          id="userIds"
          name="userIds"
          required
        >
          <option
            v-for="user in userList.users"
            :key="user.id"
            :value="user.id"
          >
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
import { onMounted, reactive, ref } from "vue";
import router from "../../router";
import { useRoute } from "vue-router";
export default {
  setup() {
    const route = useRoute();
    let usergroup = reactive({
      id: "",
      name: "",
      description: "",
      userIds: "",
    });
    const users = ref([]);
    let errors = ref("");

    onMounted(() => {
      const id = route.params.id;
      showUsergroup(id);
      getUsers(id);
    });
    const getUsers = async (groupId) => {
      await axios
        .get(`/api/getUsersWithSpecifiedGroupId/${groupId}`)
        .then((response) => {
          users.value = response.data;
        })
        .catch((error) => {
          console.log(error);
          users.value = [];
        });
    };
    const showUsergroup = async (id) => {
      await axios
        .get(`/api/usergroup/${id}`)
        .then((response) => {
          const { id, name, description, userIds } = response.data;
          usergroup.id = id;
          usergroup.name = name;
          usergroup.description = description;
          usergroup.userIds = userIds;
        })
        .catch((error) => {
          console.log(error);
        });
    };
    const updateUsergroup = async (id) => {
      await axios
        .put(`/api/usergroup/update/${id}`, usergroup)
        .then((response) => {
          router.push("/usergroups");
        })
        .catch((error) => {
          errors.value = error.response.data.message;
          console.log(error.response.data.message);
        });
    };

    return {
      users,
      usergroup,
      errors,
      showUsergroup,
      updateUsergroup,
    };
  },
};
</script>

<style>
</style>