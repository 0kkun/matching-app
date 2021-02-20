<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>
            <div class="col-sm-9">

                <div>
                    <div class="text-center h3 p-3 text-secondary">Received Like Request List</div>
                    <div class="card-columns pl-2">
                        <div v-for="user in users" :key="user.id">
                            <div class="card search-user-card">
                                <div v-if="user.image_name=='no_image.png'" class="text-center">
                                    <img @click="openModal(user)" class="card-img-top search-card-image" src="/images/default/no_image.png">
                                </div>
                                <div v-else class="text-center">
                                    <img @click="openModal(user)" class="card-img-top search-card-image" :src="'/images/uploads/' + user.image_name">
                                </div>
                                <div class="card-body p-2 d-flex justify-content-between">
                                    <div>
                                        <div>{{ user.name }} ( {{ user.age }} ) {{ user.pref }} </div>
                                        <div class="tweet-text">{{ user.tweet }}</div>
                                    </div>
                                    <div class="pt-3">
                                        <div @click="likeRequest(user.id)" href="" class="like-btn" :class="{ red:user.is_already_liked }"><i class="fas fa-thumbs-up">：{{ user.likes_count }}</i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <transition>
                    <ProfileModal :userProf="modalArg" v-show="showContent" @close="showContent = false" />
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from '../components/SideBar.vue'
import ProfileModal from '../components/ProfileModal.vue'

export default {
    components: {
        SideBar,
        ProfileModal,
    },
    data() {
        return {
            users: {},
            loadStatus: false,
            showContent: false,
            modalArg: '',
        }
    },
    mounted() {
        // いいねリクエストをしてきたユーザー取得
        this.fetchUsersForLikeRequested();
    },
    methods: {
        fetchUsersForLikeRequested() {
            axios.get('/api/v1/like/fetch_users_list')
            .then((response) => {
                this.users = Object.values(response.data.data);
                this.loadStatus = true;
                console.log(this.users);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        likeRequest(receiveUserId) {
            axios.post('/api/v1/like/create',{
                receive_user_id: receiveUserId
            })
            .then((response) => {
                this.rejectMatchingUser(receiveUserId);
                console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        // リクエストしてきたユーザーから、マッチングしたユーザーを削除する
        rejectMatchingUser(receiveUserId) {
            console.log('start');
            this.users = this.users.filter((user) => {
                    return user.id !== receiveUserId;
            },this);
        },
        openModal: function(user) {
            this.showContent = true;
            this.modalArg = user;
        },
        closeModal: function() {
            this.showContent = false;
            this.modalArg = '';
        },
    }
}
</script>

<style lang="scss" scoped>
.search-user-card {
    height:290px;
    width:250px;
}
.search-card-image {
    width: auto;
    max-height: 200px;
    cursor: pointer;
}
.like-btn {
    background-color: rgb(247, 135, 154);
    color: white;
    cursor: pointer;
    border-radius:3rem;
    padding: 5px;
}
.tweet-text {
    background-color: rgb(212, 229, 236);
    border-radius:10px;
    padding: 5px;
}
.red {
    background-color: red;
}
</style>