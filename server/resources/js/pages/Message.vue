<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-2 pt-3">
                <div class="h4 text-center font-roundedmplus1c">Match List</div>
                <ul>
                    <li v-for="(user, index) in users" 
                        :key="`first-${index}`"
                        :class="{ active:messageFocusUserId==user.id }"
                        @click="messageFocus(user.id)"
                        class="name-list border"
                    >
                        {{ user.name }}<i class="fas fa-angle-right float-right h4 pr-2"></i>
                    </li>
                </ul>
            </div>

            <!-- メッセージ表示 -->
            <div class="col-sm-7 bg-white border rounded mt-3">
                <div class="message-box-aria" id="message-box-aria">
                    <div v-for="(mes, index) in showMessage" :key="`second-${index}`">
                        <div v-if="mes.send_user_id!=loginUserId" class="d-flex" style="clear:both;">
                            <div class="name">{{ mes.name }}</div>
                            <div class="message">{{ mes.message }}</div>
                        </div>

                        <div v-else class="d-flex float-right" style="clear:both;">
                            <div class="message">{{ mes.message }}</div>
                            <div class="name">{{ mes.name }}</div>
                        </div>
                    </div>
                </div>


                <div class="input-group pb-3">
                    <textarea v-model="inputMessage" maxLength="400" cols="" rows="2" wrap="hard" class="form-control input-textarea" placeholder="Input message..."></textarea>
                    <div class="input-group-append">
                        <button @click.prevent="sendMessage()" class="btn btn-outline-secondary" type="button">
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

// メッセ送信後にスクロールさせるタイマー
const MessageTimeOut = 100;

export default {
    components: {
        SideBar,
    },
    data() {
        return {
            users: {},
            messages: {},
            showMessage: {},
            messageFocusUserId: '',
            inputMessage: '',
            loginUserId: '',
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
                this.loginUserId = response.data.data.login_user_id;
                // もし表示ユーザーが選択されていなければ初期は一番上のユーザーを選択
                if ( this.messageFocusUserId == '' ) {
                    this.messageFocusUserId = this.users[0].id;
                }
                this.messageFocus(this.messageFocusUserId);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        messageFocus(userId) {
            this.inputMessage = '';
            this.messageFocusUserId = userId;
            this.showMessage = this.messages;
            this.showMessage = this.showMessage.filter((mes) => {
                return mes.send_user_id == userId || mes.send_user_id == this.loginUserId && mes.receive_user_id == userId;
            },this);
            // NOTE: タイムアウトを設定しないとスクロールされない
            setTimeout(this.scrollMoveBottom, MessageTimeOut);
        },
        sendMessage() {
            axios.post('/api/v1/message/create', {
                send_user_id: this.loginUserId,
                receive_user_id: this.messageFocusUserId,
                message: this.inputMessage,
            })
            .then((response) => {
                this.inputMessage = '';
                this.fetchMatchedUsersList();
                this.messageFocus(this.messageFocusUserId);
                console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        scrollMoveBottom() {
            const obj = document.getElementById('message-box-aria');
            obj.scrollTop = obj.scrollHeight;
        }
    },
}
</script>

<style lang="scss" scoped>
.name {
    margin: 1.8em 0;
    padding: 8px 10px;
    white-space: nowrap;
    cursor: pointer;
}
.message {
    margin: 1.5em 0;
    padding: 7px 10px;
    min-width: 10px;
    max-width: 100%;
    color: #555;
    font-size: 16px;
    line-height: 30px;
    background: #e0edff;
    border-radius: 15px;
    white-space: pre-wrap;
    word-wrap:break-word;
}
.message-box-aria {
    height: 70vh;
    overflow: scroll;
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
.input-textarea {
    max-height: 200px;
}
</style>