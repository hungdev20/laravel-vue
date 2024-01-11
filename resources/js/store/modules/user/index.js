import router from "../../../router";

const state = {
    //define variables
    users: [],
    user: {},
    errors: {},
};

const mutations = {
    // update variable value
    UPDATE_USERS(state, payload) {
        state.users = payload.users;
        state.user = payload.user;
    },
};

const actions = {
    // action to be performed
    getUsers(context, payload) {
        axios
            .get("/api/users", {
                params: payload
                    ? {
                          ...payload
                      }
                    : "",
            })
            .then((response) => {
                context.commit("UPDATE_USERS", {
                    ...state,
                    users: response.data,
                });
            })
            .catch((error) => {
                context.commit("UPDATE_USERS", []);
            });
    },
    deleteUser(context, payload) {
        axios;
        if (confirm("Are you sure to delete this user ?")) {
            axios
                .get(`/api/user/delete/${payload}`)
                .then((response) => {
                    context.dispatch("getUsers");
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    showUser(context, payload) {
        axios
            .get(`/api/user/${payload}`)
            .then((response) => {
                context.commit("UPDATE_USERS", {
                    ...state,
                    user: response.data,
                });
            })
            .catch((error) => {
                console.log(error);
            });
    },
    updateUser(context, payload) {
        axios
            .put(`/api/user/update/${payload.id}`, payload)
            .then((response) => {
                context.commit("UPDATE_USERS", {
                    ...state,
                    user: response.data,
                });
                router.push({ name: "UserList" });
            })
            .catch((error) => {
                context.commit("UPDATE_USERS", {
                    ...state,
                    errors: error.response.data.message,
                });
            });
    },
};

const getters = {
    users: (state) => state.users,
    user: (state) => state.user,
    errors: (state) => state.errors,
};
const userModule = {
    state,
    mutations,
    actions,
    getters,
};
export default userModule;
