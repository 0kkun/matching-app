<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <template v-if="!isShowEdit">
                    <div class="card mt-3">
                        <div class="text-center">
                            <img v-if="user.image_name=='no_image.png'" class="mt-3 preview-image" :src="'/images/default/no_image.png'">
                            <img v-else class="mt-3 preview-image" :src="'/images/uploads/' + user.image_name">
                        </div>
                        <div class="h3 text-center pt-2">{{ user.name }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 text-center pt-2">{{ user.tweet }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 font-weight-bold text-center">自己紹介</div>
                        <div class="h5 text-center p-3 ml-3 mr-3 bg-light">{{ user.introduction }}</div>
                    </div>
                        
                    <div class="card mt-2 p-3">
                        <div class="row">
                            <div class="col-6 h5 font-weight-bold text-right">
                                <div>年齢：</div>
                                <div class="pt-2">趣味：</div>
                                <div class="pt-2">住所：</div>
                                <div class="pt-2">仕事：</div>
                                <div class="pt-2">性別：</div>
                                <div class="pt-2">血液型：</div>
                            </div>
                            <div class="col-6 h5">
                                <div>{{ user.age }}</div>
                                <div class="pt-2">{{ user.hobby }}</div>
                                <div class="pt-2">{{ user.pref }}</div>
                                <div class="pt-2">{{ user.job }}</div>
                                <div class="pt-2">{{ user.sex == 1 ? '男' : '女'}}</div>
                                <div class="pt-2">{{ user.blood_type }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center m-2">
                        <button @click="isShowEdit=true" class="btn btn-danger w-100">編集する</button>
                    </div>
                </template>
                <template v-else>
                    <div class="card mt-3 p-3">
                        <div class="h2 text-center p-3">編集画面</div>
                        <form action="" class="form-group" enctype="multipart/form-data">

                            <div class="text-center">
                                <div class="h5">プロフィール画像</div>
                                <label class="btn btn-primary">
                                    Choose File
                                    <input style="display:none;" ref="preview" @change="uploadFile()" name="image" type="file" accept="image/jpeg, image/png">
                                </label>
                                <div v-if="url">
                                    <img :src="url" class="preview-image">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3 text-right">
                                    <div class="h5 pt-2 mt-2">名前：</div>
                                    <div class="h5 pt-2 mt-3">一言：</div>
                                    <div class="h5 pt-2 mt-3">自己紹介：</div>
                                    <div class="h5 mt-3 hobby-title">趣味：</div>
                                    <div class="h5 mt-3 pt-2 mt-3">住所：</div>
                                    <div class="h5 mt-3 pt-2 mt-3">仕事：</div>
                                    <div class="h5 mt-3 pt-2 mt-3">血液型：</div>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control w-50 mt-2" v-model="user.name">
                                    <input type="text" class="form-control w-50 mt-2" v-model="user.tweet">
                                    <textarea type="text" class="form-control mt-2" style="height:200px;" v-model="user.introduction"></textarea>
                                    <input type="text" class="form-control w-50 mt-2" v-model="user.hobby">
                                    <select class="form-control w-50 mt-2" name="prefecture_id" v-model="user.prefecture_id" options="prefLists">
                                        <option v-for="(pref, index) in prefLists" :key="pref.id" :value="index">{{ pref }}</option>
                                    </select>
                                    <input type="text" class="form-control w-50 mt-2" v-model="user.job">
                                    <select class="form-control w-50 mt-2" name="blood_type" v-model="user.blood_type" options="prefLists">
                                        <option v-for="blood in bloodTypeLists" :key="blood.id" :value="blood">{{ blood }}</option>
                                    </select>

                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button @click.prevent="updateProfile()" type="submit" class="btn btn-success m-2">保存</button>
                                <button @click.prevent="cancel()" class="btn btn-danger m-2">キャンセル</button>
                            </div>

                        </form>
                    </div>
                </template>
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
            prefLists: [],
            bloodTypeLists: [],
            isShowEdit: false,
            url: '',
            file: '',
            imageName: '',
        }
    },
    mounted: function() {
        this.getLoginUserProfile();
    },
    methods: {
        getLoginUserProfile() {
            axios.get('/api/v1/profile/login_user')
            .then((response) => {
                this.user = response.data.data.login_user[0];
                this.prefLists = response.data.data.pref_lists;
                this.bloodTypeLists = response.data.data.blood_type_lists;
                this.loadStatus = true;
                console.log(this.user);
            })
            .catch((error) => {
                console.log(error);
            });
        },
        uploadFile() {
            // refを設定した要素の情報を取得できる
            this.file = this.$refs.preview.files[0];
            // ブラウザ上の一時的な置き場に画像を配置しURLを生成する
            this.url = URL.createObjectURL(this.file);
            this.imageName = this.file.name;
            this.$refs.preview.value = '';
        },
        cancel() {
            this.isShowEdit = false;
            this.url = '';
            this.file = '';
            this.imageName = '';
            console.log('canceled');
        },
        updateProfile() {
            if  (this.imageName == '') {
                this.imageName = this.user.image_name;
            }
            axios.post('/api/v1/profile/update', {
                user: {
                    name: this.user.name,
                    prefecture_id: this.user.prefecture_id,
                },
                profile: {
                    tweet: this.user.tweet,
                    introduction: this.user.introduction,
                    hobby: this.user.hobby,
                    job: this.user.job,
                    blood_type: this.user.blood_type,
                    image_name: this.imageName
                },
            })
            .then((response) => {
                this.getLoginUserProfile();
                this.isShowEdit = false;
                console.log('profile updated!');
            })
            .catch((error) => {
                console.log(error); 
            });

            // 画像のアップロード
            if (this.file != '') {
                const formData = new FormData();
                formData.append('file', this.file);
                axios.post('/api/v1/profile/image_upload', formData)
                .then((response) => {
                    console.log('image uploaded!');
                })
                .catch((error) => {
                    console.log(error); 
                });
            }
        },
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