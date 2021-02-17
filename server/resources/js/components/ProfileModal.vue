<template>
    <div class="modal-overlay">
        <!-- <transition> -->
            <div v-if="userProf!=''" class="modal-content">
                <!-- 閉じるボタン -->
                <div class="text-right">
                    <button type="button" v-on:click="$emit('close');" class="btn btn-danger h4"><i class="fas fa-times"></i></button>
                </div>
                <div>
                    <div class="card mt-3">
                        <div v-if="userProf.image_name != 'no_image.png'" class="text-center">
                            <img class="mt-3 preview-image" :src="'/images/uploads/' + userProf.image_name">
                        </div>
                        <div v-else class="text-center">
                            <img class="mt-3 preview-image" :src="'/images/default/no_image.png'">
                        </div>
                        <div class="h3 text-center pt-2">{{ userProf.name }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 text-center pt-2">{{ userProf.tweet }}</div>
                    </div>
                    <div class="card mt-2 p-3">
                        <div class="h5 font-weight-bold text-center">自己紹介</div>
                        <div class="h5 text-center p-3 ml-3 mr-3 bg-light">{{ userProf.introduction }}</div>
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
                                <div>{{ userProf.age }}</div>
                                <div class="pt-2">{{ userProf.hobby }}</div>
                                <div class="pt-2">{{ userProf.pref }}</div>
                                <div class="pt-2">{{ userProf.job }}</div>
                                <div class="pt-2">{{ userProf.sex == 1 ? '男' : '女'}}</div>
                                <div class="pt-2">{{ userProf.blood_type }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </transition> -->
    </div>
</template>


<script>
export default {
    props:["userProf"],
    data() {
        return {
            // show: false,
        }
    },
    mounted() {
        // console.log('mounted');
    },
    methods: {
        // initMethod() {
        //     this.show = false;
        // }
    }
}
</script>


<style lang="scss" scoped>
.modal-content {
    z-index: 2;
    width: 50%;
    padding: 1em;
    background: #fff;
    overflow: scroll;
    height: 90vh;
}
.modal-overlay {
    z-index: 1;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}
.hobby-title {
    padding-top: 170px;
}
.preview-image {
    max-height: 250px;
    max-width: 400px;
}
/* アニメーション */
.v-enter {
    opacity: 0;
    transform: translateY(-20px);
}
.v-enter-to {
    opacity: 1;
}
.v-enter-active {
    transition: opacity 300ms ease-out, transform 300ms ease-out;
}
.v-leave {
    opacity: 1;
}
.v-leave-to {
    opacity: 0;
    transform: scale(0.97);
}
.v-leave-active {
    transition: opacity 270ms ease-out, transform 270ms ease-out;
}
</style>