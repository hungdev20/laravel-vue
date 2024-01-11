<template>
  <div class="container mt-4">
    <div class="action-wrapper d-flex justify-content-between">
      <button class="btn btn-primary mb-2" @click="onAdd()">
        Add Usergroup
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
            <label for="name">Name:</label>
            <input
              class="form-control mt-1"
              v-model="searchOptions.name"
              type="text"
              name="name"
            />
          </div>
          <div class="form-group mt-2">
            <label for="name">Description:</label>
            <input
              class="form-control mt-1"
              type="text"
              name="description"
              v-model="searchOptions.description"
            />
          </div>
          <button
            type="button"
            class="btn btn-primary mt-3"
            @click.prevent="
              getUserGroups(
                sortCondition.tabActive,
                sortCondition[sortCondition.tabActive],
                searchOptions
              )
            "
          >
            Search
          </button>
        </form>
      </div>
    </div>
    <table class="table mt-3">
      <thead>
        <tr>
          <th v-for="(tab, index) in tabs" :key="index">
            {{ tab.title }}
            <font-awesome-icon
              :icon="['fas', 'sort-up']"
              v-if="sortCondition[tab.name] === 'desc'"
              @click="getUserGroups(tab.name, 'asc', searchOptions)"
            />
            <font-awesome-icon
              :icon="['fas', 'sort-down']"
              v-else
              @click="getUserGroups(tab.name, 'desc', searchOptions)"
            />
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(group, index) in usergroups" :key="index">
          <td>{{ group.name }}</td>
          <td>{{ group.description }}</td>
          <td>{{ formatTime(group.created_at) }}</td>
          <td>{{ formatTime(group.updated_at) }}</td>
          <td>
            <button class="btn btn-warning" @click="onEdit(group.id)">
              Edit
            </button>
            <button
              class="btn btn-danger ml-2"
              @click="deleteUsergroup(group.id)"
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
export default {
  name: "usergroups",
  data() {
    return {
      usergroups: [],
      tabs: [
        {
          title: "Name",
          name: "name",
          isSortable: true,
        },
        {
          title: "Description",
          name: "description",
          isSortable: true,
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
        name: "",
        description: "",
      },
      filteredSearchOptions: {},
      sortCondition: {
        name: "asc",
        description: "desc",
        created_at: "asc",
        updated_at: "asc",
        tabActive: "",
      },
      searchVisibility: false,
    };
  },
  mounted() {
    this.getUserGroups();
  },
  methods: {
    onAdd() {
      router.push("/usergroup/add");
    },
    onEdit(id) {
      router.push("/usergroup/" + id);
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
    async getUserGroups(sort, direction, search) {
      search ? this.filterSearch(search) : "";
      sort && direction ? this.setSortCondition(sort, direction) : "";
      console.log(this.filteredSearchOptions);
      await axios
        .get("/api/usergroups", {
          params: {
            sort,
            direction,
            ...this.filteredSearchOptions,
          },
        })
        .then((response) => {
          this.usergroups = response.data;
        })
        .catch((error) => {
          console.log(error);
          this.usergroups = [];
        });
    },
    async deleteUsergroup(id) {
      if (confirm("Are you sure to delete this usergroup ?")) {
        await axios
          .get(`/api/usergroup/delete/${id}`)
          .then((response) => {
            this.getUserGroups();
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
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