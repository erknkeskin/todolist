<template>
  <div>
    <form>
      <div class="row">
        <label for="user_email">e-mail</label>
        <input type="email" name="user_email" v-model="user_email" id="user_email" placeholder="e-mail"/>
      </div>
      <div class="row">
        <label for="user_pass">password</label>
        <input type="password" name="user_pass" v-model="user_pass" id="user_pass" placeholder="password"/>
      </div>
      <div class="row">
        <button type="button" v-on:click="login">login</button>
      </div>
    </form>
  </div>
</template>

<script>

import axios from 'axios';

let axiosOptions = {
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
}

export default {
  name: "Login",
  data() {
    return {
      user_email: '',
      user_pass: ''
    }
  },
  methods: {
    login() {
      axios.post('http://127.0.0.1:8000/api/v1/auth/login', 'user_email=' + this.user_email + '&user_pass=' + this.user_pass, axiosOptions)
          .then((response) => {
            if ( response.data.status === 'ok' ) {
              this.$alertify.success('<i class="fas fa-check"></i> '+response.data.message);
              localStorage.setItem('_token', response.data.token);
              localStorage.setItem('user_id', response.data.user_data.user_id);
              localStorage.setItem('user_email', response.data.user_data.user_email);
              localStorage.setItem('user_fullname', response.data.user_data.user_fullname);
              window.location.reload();
            } else {
              this.$alertify.error('<i class="fas fa-exclamation-circle"></i> '+response.data.message);
            }
          }).catch((response) => {
        console.log(response);
      });
    }
  }
}
</script>

<style scoped>
form {
  display: block;
  width: 50%;
  margin: 50px auto 0;
}

form .row {
  margin: 5px 0px;
}

form label {
  text-indent: 5px;
  width: 100%;
  display: block;
  color: #212121;
  font-size: 14px;
  height: 30px;
  line-height: 30px;
}

form input {
  width: 100%;
  height: 30px;
  text-indent: 10px;
  border: 1px solid #eee;
  border-radius: 4px;
  color: #212121;
}

form button {
  border: none;
  border-radius: 4px;
  color: #fff;
  background: #47b7d5;
  padding: 5px 10px;
  float: right;
  cursor: pointer;
  transition: all 200ms ease-in-out;
}

form button:hover {
  opacity: .7;
}
</style>