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
                        <div class="h3 text-center pt-2">{{ profile.name }}</div>
                        <div class="h4 text-center pt-2">一言 : 今日もいい天気</div>
                        <div class="h4 text-center text-primary">--自己紹介--</div>
                        <div class="h5 text-center p-3 ml-3 mr-3 bg-light">どうもです。テニス仲間募集中</div>
                        <div class="h5 text-center">年齢 : {{ profile.age }}</div>
                        <div class="h5 text-center">趣味 : 野球</div>
                        <div class="h5 text-center">住所 : {{ profile.pref }}</div>
                        <button @click="isShowEdit=true" class="btn btn-danger m-2">編集する</button>
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
                                </div>
                                <div class="col-9">
                                    <input type="text" name="name" class="form-control w-50 mt-2" :value="profile.name">
                                    <input type="text" name="tweet" class="form-control w-50 mt-2">
                                    <textarea type="text" name="introduction" class="form-control mt-2" style="height:200px;"></textarea>
                                    <input type="text" name="tweet" class="form-control w-50 mt-2">
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
            profile: [],
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
                this.profile = response.data.data;
                // this.loadStatus = true;
                console.log('status:' + response.data.status);
                console.log(response.data.data);
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