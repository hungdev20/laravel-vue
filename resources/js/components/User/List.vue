<template>
  <div class="container mt-4">
    <h1>User List</h1>
    <div class="action-wrapper d-flex justify-content-between">
      <button class="btn btn-primary mb-3 ml-1" @click.prevent="redirectTo()">
        Add User
      </button>
      <div class="search-container form-inline">
        <font-awesome-icon
          :icon="['fas', 'filter']"
          class="icon-filter"
          @click="setSearchVisibility"
        />
        <form class="modal-search" v-if="searchVisibility">
          <font-awesome-icon
            :icon="['fas', 'xmark']"
            class="close-modal"
            @click="setSearchVisibility"
          />
          <div class="form-group mt-2">
            <label for="name">Username:</label>
            <input
              class="form-control mt-1"
              v-model="searchOptions.username"
              type="text"
              name="name"
            />
          </div>
          <div class="form-group mt-2">
            <label for="name">Email:</label>
            <input
              class="form-control mt-1"
              type="text"
              name="description"
              v-model="searchOptions.email"
            />
          </div>
          <button
            type="button"
            class="btn btn-primary mt-3"
            @click.prevent="sortUsers(sortCondition.tabActive, sortCondition[sortCondition.tabActive], searchOptions)"
          >
            Search
          </button>
        </form>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th v-for="(tab, index) in tabs" :key="index">
            {{ tab.title }}
            <span v-if="tab.isSortable">
              <font-awesome-icon
                :icon="['fas', 'sort-up']"
                v-if="sortCondition[tab.name] === 'desc'"
                @click="sortUsers(tab.name, 'asc', searchOptions)"
              />
              <font-awesome-icon
                :icon="['fas', 'sort-down']"
                v-else
                @click="sortUsers(tab.name, 'desc', searchOptions)"
              />
            </span>
          </th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.username }}</td>
          <td>{{ user.firstName + " " + user.lastName }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.usergroup ? user.usergroup.name : "" }}</td>
          <td>{{ formatTime(user.created_at) }}</td>
          <td>{{ formatTime(user.updated_at) }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="onEdit(user.id)">
              Edit
            </button>
            <button
              class="btn btn-danger btn-sm ml-2"
              @click="deleteUser(user.id)"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import moment from "moment";
import router from "../../router";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "users",
  data() {
    return {
      tabs: [
        {
          title: "Username",
          name: "username",
          isSortable: true,
        },
        {
          title: "Fullname",
          name: "fullname",
          isSortable: false,
        },
        {
          title: "Email",
          name: "email",
          isSortable: true,
        },
        {
          title: "Usergroup",
          name: "usergroup",
          isSortable: false,
        },
        {
          title: "Created At",
          name: "created_at",
          isSortable: true,
        },
        {
          title: "Updated At",
          name: "updated_at",
          isSortable: true,
        },
      ],
      searchOptions: {
        username: "",
        email: "",
      },
      filteredSearchOptions: {},
      sortCondition: {
        username: "asc",
        fullname: "desc",
        email: "desc",
        created_at: "asc",
        updated_at: "asc",
        tabActive: ""
      },
      searchVisibility: false,
    };
  },
  mounted() {
    this.getUsers();
  },
  computed: {
    ...mapGetters(["users"]),
  },
  methods: {
    redirectTo() {
      router.push({ name: "AddUser" });
    },
    onEdit(id) {
      router.push("/user/" + id);
    },
    formatTime(time) {
      return moment(String(time)).format("MM/DD/YYYY hh:mm");
    },
    setSearchVisibility() {
      this.searchVisibility = !this.searchVisibility;
    },
    setSortCondition(sort, direction) {
      if (sort && direction) {
        this.sortCondition = {
          ...this.sortCondition,
          [sort]: direction,
          tabActive: sort
        };
      }
    },
    filterSearch(search) {
      Object.keys(search).forEach((key) => {
        if (search[key]) {
          this.filteredSearchOptions[key] = search[key];
        }
      });
    },
    sortUsers(sort, direction, search) {
      search ? this.filterSearch(search) : "";
      sort && direction ? this.setSortCondition(sort, direction) : "";
      this.getUsers({
        sort,
        direction,
        ...this.filteredSearchOptions,
      });
    },
    ...mapActions(["getUsers", `deleteUser`]),
  },
};
</script>

<style>
.search-container {
  position: relative;
}
.modal-search {
  width: 240px;
  min-height: 100px;
  position: absolute;
  max-height: 250px;
  top: -20px;
  left: -40px;
  background: #ddd;
  padding: 15px;
  overflow: auto;
}
.search-visible {
  display: block;
}
.close-modal {
  position: absolute;
  cursor: pointer;
  right: 20px;
  font-size: 20px;
}
.icon-filter {
  font-size: 30px;
  color: #007bff;
  cursor: pointer;
}
</style>