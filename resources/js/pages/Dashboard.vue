<template>
  <div class="container">
    <h2>Dashboard:</h2>
    <button type="button" class="btn btn-dark mt-2" @click="logout">
      Logout
    </button>
  </div>
</template>

<script>
import router from "../router";
import { useStore } from 'vuex'

export default {
  setup() {
    const store = useStore();
    function logout() {
      store.dispatch('removeToken');
      router.push({ name: "Login" });
    }
    return {
      logout,
    };
  },
};
</script>

<style>
</style>