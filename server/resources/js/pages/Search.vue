<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div class="card mt-3 mb-3 pt-3 pb-3">
                    <div class="input-group pr-5 pl-5">
                        <input v-model="keywords" type="text" class="form-control" placeholder="Please input keywords..." aria-label="Please input keywords...">
                    </div>

                    <div class="row text-right">
                        <div class="col-6">
                            <div class="pt-3 pl-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="1" v-model="checkSex">
                                    <label class="form-check-label" for="sex">男</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="2" v-model="checkSex">
                                    <label class="form-check-label" for="sex">女</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" value="" v-model="checkSex" checked>
                                    <label class="form-check-label" for="sex">指定無し</label>
                                </div>
                            </div>
                            
                            <div class="pt-2  pl-3">
                                <label>血液型：</label>
                                <select name="blood_type" v-model="checkBloodType">
                                    <option value="">指定無し</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div class="pt-2  pl-3">
                                <label>住所：</label>
                                <select name="prefecture_id" v-model="checkPref">
                                    <option value="">指定無し</option>
                                    <option v-for="(pref, index) in prefLists" :key="pref.id" :value="index">{{ pref }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 text-left">
                            <div class="pt-3 pl-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="image_setting" v-model="checkImageSetting">
                                    <label class="form-check-label" for="image_setting">画像設定済み</label>
                                </div>
                            </div>
                            <div class="pt-2 pl-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="good" v-model="checkLikeSort">
                                    <label class="form-check-label" for="good">いいねが多い順</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right pr-4">
                        <button @click="reset()" href="#" class="btn btn-danger mr-2">Reset</button>
                        <button @click="search()" class="btn btn-success" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div v-if="searchMode">
                    <div class="text-center">検索中</div>
                    <div class="card-columns pl-2">
                        <div v-for="user in searchUsers" :key="user.id">
                            <div class="card search-user-card">
                                <div v-if="user.image_name=='no_image.png'" class="text-center card-image-area">
                                    <img @click="openModal(user)" class="card-img-top search-card-image" src="/images/default/no_image.png">
                                </div>
                                <div v-else class="text-center card-image-area">
                                    <img @click="openModal(user)" class="card-img-top search-card-image" :src="'/images/uploads/' + user.image_name">
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <div>{{ user.name }} ( {{ user.age }} ) {{ user.pref }} </div>
                                        <p>{{ user.tweet }}</p>
                                    </div>
                                    <div class="pt-3">
                                        <div @click="likeRequest(user.id)" href="" class="like-btn" :class="{ red:user.is_already_liked }"><i class="fas fa-thumbs-up">：{{ user.likes_count }}</i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div class="text-center">全件表示中</div>
                    <div class="card-columns pl-2">
                        <div v-for="user in users" :key="user.id">
                            <div class="card search-user-card">
                                <div v-if="user.image_name=='no_image.png'" class="text-center card-image-area">
                                    <img @click="openModal(user)" class="card-img-top search-card-image" src="/images/default/no_image.png">
                                </div>
                                <div v-else class="text-center card-image-area">
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
            prefLists: {},
            searchUsers: '',
            loadStatus: false,
            searchMode: false,
            checkSex: '',
            checkImageSetting: '',
            checkBloodType: '',
            checkPref: '',
            checkLikeSort: '',
            keywords: '',
            showContent: false,
            modalArg: '',
        }
    },
    mounted() {
        this.fetchUsersList();
    },
    methods: {
        async fetchUsersList() {
            await axios.get('/api/v1/search/fetch_users_list')
            .then((response) => {
                this.users = Object.values(response.data.data.users);
                this.prefLists = response.data.data.pref_lists;
                this.loadStatus = true;
            })
            .catch((error) => {
                console.log(error);
            });
        },
        openModal: function(user) {
            this.showContent = true;
            this.modalArg = user;
        },
        closeModal: function() {
            this.showContent = false;
            this.modalArg = '';
        },
        search() {
            this.searchMode = true;
            this.searchUsers = this.users;

            // 性別のフィルタ
            if (this.checkSex != '') {
                this.searchUsers = this.searchUsers.filter((user) => {
                    return user.sex == this.checkSex
                },this);
            }
            // 画像のフィルタ
            if (this.checkImageSetting != '') {
                this.searchUsers = this.searchUsers.filter((user) => {
                    return user.image_name != 'no_image.png';
                },this);
            }
            // 血液型のフィルタ
            if (this.checkBloodType != '') {
                this.searchUsers = this.searchUsers.filter((user) => {
                    return user.blood_type == this.checkBloodType;
                },this);
            }
            // 都道府県のフィルタ
            if (this.checkPref != '') {
                this.searchUsers = this.searchUsers.filter((user) => {
                    return user.prefecture_id == this.checkPref;
                },this);
            }
            // キーワード検索
            if (this.keywords != '') {
                this.searchUsers = this.searchUsers.filter((user) => {
                    return user.introduction.indexOf(this.keywords) != -1
                },this);
            }
            // いいねが多い順にソート
            if (this.checkLikeSort != '') {
                this.searchUsers = this.searchUsers.sort(function(a, b) {
                    if (a.likes_count < b.likes_count) {
                        return 1;
                    } else {
                        return -1;
                    }
                })
            }
            // 何もチェックされていなければ検索モードを解除
            if (this.checkImageSetting=='' && this.checkSex=='' && this.checkBloodType=='' && this.checkPref=='' && this.keywords=='' && this.checkLikeSort=='') {
                this.searchUsers = '';
                this.searchMode = false;
            }
        },
        reset() {
            this.searchUsers = '';
            this.checkSex = '';
            this.checkImageSetting = '';
            this.checkBloodType = '';
            this.checkPref = '';
            this.keywords = '';
            this.checkLikeSort = '';
            this.searchMode = false;
        },
        async likeRequest(receiveUserId) {
            await axios.post('/api/v1/like/create',{
                receive_user_id: receiveUserId
            })
            .then((response) => {
                // 正常にいいね処理が行われた場合はいいね数を更新
                if (response.data.status == 201) {
                    this.likeCountUp(receiveUserId);
                }
                if (response.data.status == 204) {
                    this.likeCountDown(receiveUserId);
                }
                console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        likeCountUp(receiveUserId) {
            for (let i=0; i < this.users.length; i++) {
                if (this.users[i].id == receiveUserId) {
                    this.users[i].likes_count += 1;
                    this.users[i].is_already_liked = true;
                    console.log('like count up success!');
                    break;
                }
            }
        },
        likeCountDown(receiveUserId)  {
            for (let i=0; i < this.users.length; i++) {
                if (this.users[i].id == receiveUserId) {
                    this.users[i].likes_count -= 1;
                    this.users[i].is_already_liked = false;
                    console.log('like count down success!');
                    break;
                }
            }
        }
    },
}
</script>

<style lang="scss" scoped>
.search-user-card {
    height:290px;
    width:250px;
}
.card-image-area {
    height: 200px;
}
.search-card-image {
    width: 100%;
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
