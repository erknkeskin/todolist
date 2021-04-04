<template>
  <div>
    <div class="user">
      <a><strong>welcome,</strong> {{ user_name }} (<a class="btn" @click="logout">logout</a>)</a>
    </div>
    <div class="wrapper">
      <h1>All Todos</h1>
      <form @submit.prevent="addNewItem">
        <input type="text" name="item-input" placeholder="birşeyler yaz..." v-model="title"/>
      </form>
      <div class="todos">
        <ul>
          <li v-for="(item, index) in items" :key="index"><span><input
              :checked="item.todo_status == '2' ? 'checked' : ''"
              @change="changeStatus(item.todo_id, item.todo_status)"
              type="checkbox" name=""/> {{
              item.todo_detail
            }}</span><a @click="removeItem(index, item.todo_id)"><i class="fas fa-trash"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

let axiosOptions = {
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  }
}

export default {
  name: "Todos",
  data() {
    return {
      title: '',
      user_name: null,
      items: []
    }
  },
  mounted() {
    this.getAllTodos();
    this.user_name = localStorage.getItem('user_fullname')
  },
  methods: {
    changeStatus(item_id, status_id) {
      let user_id = localStorage.getItem('user_id');
      let token = localStorage.getItem('_token');

      let new_status = status_id == '2' ? '1' : '2';

      axios.post('http://127.0.0.1:8000/api/v1/todo/done', 'todo_user_id=' + user_id + '&todo_id=' + item_id + '&todo_status=' + new_status + '&token=' + token, axiosOptions)
          .then((response) => {
            if (response.data.status === 'ok') {
              this.items = [];
              this.getAllTodos();
              this.$alertify.success(response.data.message);
            } else {
              this.$alertify.error(response.data.message);
            }
          })
    },
    logout() {
      localStorage.clear();
      window.location.reload();
    },
    removeItem(index, item_id) {
      let user_id = localStorage.getItem('user_id');
      let token = localStorage.getItem('_token');
      axios.post('http://127.0.0.1:8000/api/v1/todo/delete', 'todo_user_id=' + user_id + '&todo_id=' + item_id + '&token=' + token, axiosOptions)
          .then((response) => {
            if (response.data.status === 'ok') {
              this.items.splice(index, 1);
              this.$alertify.success(response.data.message);
            } else {
              this.$alertify.error(response.data.message);
            }
          })
    },
    addNewItem() {
      let user_id = localStorage.getItem('user_id');
      let token = localStorage.getItem('_token');
      axios.post('http://127.0.0.1:8000/api/v1/todo/add', 'todo_user_id=' + user_id + '&todo_detail=' + this.title + '&token=' + token, axiosOptions)
          .then((response) => {
            if (response.data.status === 'ok') {
              this.$alertify.success(response.data.message);
              this.title = '';
              this.items = [];
              this.getAllTodos();
            } else {
              this.$alertify.error(response.data.message);
            }
          })
    },
    getAllTodos() {
      let user_id = localStorage.getItem('user_id');
      let token = localStorage.getItem('_token')
      axios.get('http://127.0.0.1:8000/api/v1/todo/all?user_id=' + user_id + '&token=' + token, axiosOptions)
          .then((response) => {
            if (response.data.data) {
              for (let i = 0; i < response.data.data.length; i++) {
                this.items.push(response.data.data[i]);
              }
            }
          })
    }
  }
}
</script>

<style scoped>
.wrapper {
  max-width: 500px;
  margin: 100px auto 0;
}

form {
  width: 100%;
}

form > input {
  width: 100%;
  height: 35px;
  text-indent: 10px;
  border: 1px solid #eee;
  border-radius: 4px;
  color: #212121;
}

input:focus {
  outline: 0;
}

div.todos {
  margin-top: 20px;
  margin-left: 10px;
}

ul {
  margin: 0;
  padding: 0;
}

ul > li {
  list-style: none;
  height: 25px;
  line-height: 25px;
  display: flex;
  justify-content: space-between;
  padding: 0px 10px;
  border-radius: 4px;
}

ul > li:hover {
  background-color: #d1d1d1;
}

ul > li:hover > a, ul > li:hover > span {
  color: #fff;
}

ul > li:hover > a, ul > li:hover > span > i {
  cursor: pointer;
}

ul > li > a {
  color: #212121;
  font-size: 14px;
}

ul > li > span {
  color: #212121;
}

div.user {
  position: absolute;
  right: 2%;
  top: 3%;
}

div.user > a {
  color: #212121;
  font-size: 13px;
}

div.user > a > .btn {
  color: #2aa2d2;
  cursor: pointer;
}

</style>
