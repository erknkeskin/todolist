<template>
  <div id="app">
    <Login v-if="!isLogin"/>
    <Todos v-else/>
  </div>
</template>

<script>
import Todos from "./components/Todos";
import Login from "./components/Login";

import axios from "axios";

let axiosOptions = {
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
}

export default {
  name: 'App',
  components: {Login, Todos},
  data() {
    return {
      isLogin: false,
    }
  },
  mounted() {
    this.checkLogin();
  },
  methods: {
    checkLogin() {
      let _token = localStorage.getItem('_token');
      if ( _token !== null ) {
        axios.get('http://127.0.0.1:8000/api/v1/auth/user?token='+_token, axiosOptions)
        .then((response)=>{
          if ( response.data.status === 'ok' ) {
            this.isLogin = true;
          }
        });
      } else {
        return false;
      }
    }
  }
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
}

input {
  padding: 0;
  margin: 0;
}

input:focus {
  outline: 0;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
