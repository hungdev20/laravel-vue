const state = {
    //define variables
    token: localStorage.getItem("token") || 0,
};

const mutations = {
    // update variable value
    UPDATE_TOKEN(state, payload) {
        state.token = payload;
    },
};

const actions = {
    // action to be performed
    setToken(context, payload) {
        localStorage.setItem("token", payload);
        context.commit("UPDATE_TOKEN", payload);
    },
    removeToken(context) {
        localStorage.removeItem("token");
        context.commit("UPDATE_TOKEN", 0);
    },
};

const getters = {
    // get state variable value
    getToken: function (state) {
        return state.token;
    },
};
const authModule = {
    state,
    mutations,
    actions,
    getters,
};
export default authModule;
