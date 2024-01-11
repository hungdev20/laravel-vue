<template>
  <div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item" v-if="!getToken">
          <router-link class="text-white" :to="{ name: 'Login' }"
            >Login</router-link
          >
        </li>
        <li class="nav-item" v-if="getToken">
          <router-link class="text-white ml-2" :to="{ name: 'Dashboard' }"
            >Dashboard</router-link
          >
        </li>
        <li class="nav-item" v-if="getToken">
          <router-link class="text-white ml-2" :to="{ name: 'UserList' }"
            >Users</router-link
          >
        </li>
        <li class="nav-item" v-if="getToken">
          <router-link class="text-white ml-2" :to="{ name: 'UserGroupList' }"
            >UserGroups</router-link
          >
        </li>
      </ul>
    </nav>
    <router-view></router-view>
  </div>
</template>
  
  <script>
import { mapGetters } from "vuex";
export default {
  name: "App",
  computed: {
    ...mapGetters(["getToken"]),
  },
};
</script>
  
  <style>
</style>