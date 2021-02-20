<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-2 pt-3">
                <div class="h4 text-center font-roundedmplus1c">Match List</div>
                <ul>
                    <li v-for="user in users" :key="user.id" @click="messageFocus(user.id)" :class="{ active:messageFocusUserId==user.id }" class="name-list border">{{ user.name }}<i class="fas fa-angle-right float-right h4 pr-2"></i></li>
                </ul>
            </div>

            <div class="col-sm-7 bg-white border rounded mt-3">

                <div class="d-flex">
                    <div class="name">たかし</div>
                    <div class="message">こんにちは</div>
                </div>

                <div class="d-flex float-right">
                    <div class="message">ヤッホー</div>
                    <div class="name">あなた</div>
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Input message..." aria-label="Input message..." aria-describedby="button-addon">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from '../components/SideBar.vue'

export default {
    components: {
        SideBar,
    },
    data() {
        return {
            users: {},
            messages: {},
            messageFocusUserId: '',
            loadStatus: false,
            showContent: false,
            modalArg: '',
        }
    },
    mounted() {
        this.fetchMatchedUsersList();
    },
    methods: {
        fetchMatchedUsersList() {
            axios.get('/api/v1/message/fetch_matched_users_list')
            .then((response) => {
                this.users = Object.values(response.data.data.users);
                this.messages = Object.values(response.data.data.messages);
                this.loadStatus = true;
                console.log(this.users);
                console.log(this.messages);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        messageFocus(userId) {
            this.messageFocusUserId = userId;
        }
    }
}
</script>

<style lang="scss" scoped>
.name {
    margin: 1.8em 0;
    padding: 8px 10px;
    cursor: pointer;
}
.message {
    margin: 1.5em 0;
    padding: 7px 10px;
    min-width: 120px;
    max-width: 100%;
    color: #555;
    font-size: 16px;
    background: #e0edff;
    border-radius: 15px;
}
ul {
    padding: 0;
}
.name-list {
    padding: 5px;
    list-style: none;
    width: 100%;
    background-color:rgb(217, 217, 217);
    cursor: pointer;
}
.active {
    background-color: rgb(154, 237, 192);
}
</style>