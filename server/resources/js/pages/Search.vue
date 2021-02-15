<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div class="card mt-3 mb-3 pt-3 pb-3">
                    <form action="">
                        <div class="input-group pr-5 pl-5">
                            <input type="text" class="form-control" placeholder="Please input keywords..." aria-label="Please input keywords...">
                        </div>

                        <div class="row text-right">
                            <div class="col-6">
                                <div class="pt-3 pl-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="" value="1">
                                        <label class="form-check-label" for="sex">男</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sex" id="" value="2" checked>
                                        <label class="form-check-label" for="sex">女</label>
                                    </div>
                                </div>
                                
                                <div class="pt-2  pl-3">
                                    <label>血液型：</label>
                                    <select name="blood_type">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>
                                <div class="pt-2  pl-3">
                                    <label>住所：</label>
                                    <select name="prefecture_id" id="">
                                        <option value="">神奈川県</option>
                                        <option value="">東京都</option>
                                        <option value="">岡山県</option>
                                        <option value="">大阪府</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 text-left">
                                <div class="pt-3 pl-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="sex" id="" value="1">
                                        <label class="form-check-label" for="sex">画像設定済み</label>
                                    </div>
                                </div>
                                <div class="pt-2 pl-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="sex" id="" value="1">
                                        <label class="form-check-label" for="sex">いいねが多い順</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right pr-4">
                            <button class="btn btn-success" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                    </form>
                </div>

                <div class="card-columns pl-2">
                    <div v-for="user in users" :key="user.id">
                        <div class="card" style="height:290px; width:250px;">
                            <div v-if="user.image_name=='no_image.png'">
                                <img class="card-img-top" style="max-height:200px;" src="/images/default/no_image.png">
                            </div>
                            <div v-else>
                                <img class="card-img-top" style="max-height:200px;" :src="'/images/uploads/' + user.image_name">
                            </div>
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <div>{{ user.name }} ( {{ user.age }} ) {{ user.pref }} </div>
                                    <p>{{ user.tweet }}</p>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary rounded-circle"><i class="fas fa-thumbs-up"></i></a>
                                </div>
                            </div>
                        </div>
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
            users: [],
            loadStatus: false,
        }
    },
    mounted() {
        this.fetchUsersList();
    },
    methods: {
        fetchUsersList() {
            axios.get('/api/v1/search/fetch_users_list')
            .then((response) => {
                this.users = response.data.data;
                this.loadStatus = true;
                console.log(this.users);
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
</style>
