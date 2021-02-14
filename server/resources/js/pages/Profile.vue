<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div v-if="!isShowEdit">
                    <div class="card mt-3">
                        <img class="mx-auto mt-3" style="width:500px; height:350px" src="/images/cat1.jpeg">
                        <div class="h3 text-center pt-2">{{ user.name }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 text-center pt-2">{{ profile.tweet }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 font-weight-bold text-center">自己紹介</div>
                        <div class="h5 text-center p-3 ml-3 mr-3 bg-light">{{ profile.introduction }}</div>
                    </div>
                        
                    <div class="card mt-2 p-3">
                        <div class="row">
                            <div class="col-6 h5 font-weight-bold text-right">
                                <div>年齢：</div>
                                <div class="pt-2">趣味：</div>
                                <div class="pt-2">住所：</div>
                                <div class="pt-2">仕事：</div>
                                <div class="pt-2">性別：</div>
                            </div>
                            <div class="col-6 h5">
                                <div>{{ user.age }}</div>
                                <div class="pt-2">{{ profile.hobby }}</div>
                                <div class="pt-2">{{ user.pref }}</div>
                                <div class="pt-2">{{ profile.job }}</div>
                                <div class="pt-2">{{ user.sex == 1 ? '男' : '女'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center m-2">
                        <button @click="isShowEdit=true" class="btn btn-danger w-100">編集する</button>
                    </div>
                </div>
                <div v-if="isShowEdit">
                    <div class="card mt-3 p-3">
                        <div class="h2 text-center p-3">編集画面</div>
                        <form action="" class="form-group" enctype="multipart/form-data">

                            <div class="text-center">
                                <div class="h5">プロフィール画像</div>
                                <label class="btn btn-primary">
                                    Choose File
                                    <input style="display:none;" ref="preview" @change="uploadFile" name="image" type="file" accept="image/jpeg, image/png">
                                </label>
                                <div v-if="url">
                                    <img :src="url" class="preview-image">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3 text-right">
                                    <div for="name" class="h5 pt-2 mt-2">名前：</div>
                                    <div for="tweet" class="h5 pt-2 mt-3">一言：</div>
                                    <div for="introduction" class="h5 pt-2 mt-3">自己紹介：</div>
                                    <div for="hobby" class="h5 mt-3 hobby-title">趣味：</div>
                                    <div for="hobby" class="h5 mt-3 pt-2 mt-3">住所：</div>
                                    <div for="hobby" class="h5 mt-3 pt-2 mt-3">仕事：</div>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="name" class="form-control w-50 mt-2" :value="user.name">
                                    <input type="text" name="tweet" class="form-control w-50 mt-2" :value="profile.tweet">
                                    <textarea type="text" name="introduction" class="form-control mt-2" style="height:200px;" :value="profile.introduction"></textarea>
                                    <input type="text" name="tweet" class="form-control w-50 mt-2" :value="profile.hobby">
                                    <select class="form-control w-50 mt-2" name="prefecture_id" v-model="user.prefecture_id" options="prefLists">
                                        <option v-for="(pref, index) in prefLists" :key="pref.id" :value="index">{{ pref }}</option>
                                    </select>
                                    <input type="text" name="job" class="form-control w-50 mt-2" :value="profile.job">
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success m-2">保存</button>
                                <button @click="isShowEdit=false" class="btn btn-danger m-2">キャンセル</button>
                            </div>

                        </form>
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
            loadStatus: false,
            user: [],
            profile: [],
            prefLists: [],
            isShowEdit: false,
            url:""
        }
    },
    mounted: function() {
        this.getLoginUserProfile();
    },
    methods: {
        getLoginUserProfile: function() {
            axios.get('/api/v1/profile/login_user')
            .then((response) => {
                this.user = response.data.data.login_user;
                this.profile = response.data.data.profile[0];
                this.prefLists = response.data.data.pref_lists;
                this.loadStatus = true;
                console.log('status:' + response.data.status);
                console.log(this.prefLists);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        uploadFile(){
            // refを設定した要素の情報を取得できる
            const file = this.$refs.preview.files[0];
            // ブラウザ上の一時的な置き場に画像を配置しURLを生成する
            this.url = URL.createObjectURL(file)
        }
    }
}
</script>

<style lang="scss" scoped>
.hobby-title {
    padding-top: 170px;
}
.preview-image {
    max-height: 250px;
    max-width: 400px;
}
</style>