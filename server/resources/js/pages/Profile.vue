<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div class="card mt-3">
                    <img class="mx-auto mt-3" style="width:500px; height:350px" src="/images/cat1.jpeg">
                    <div class="h3 text-center pt-2">ゲストさん</div>
                    <div class="h4 text-center pt-2">一言 : 今日もいい天気</div>
                    <div class="h4 text-center text-primary">--自己紹介--</div>
                    <div class="h5 text-center p-3 ml-3 mr-3 bg-light">どうもです。テニス仲間募集中</div>
                    <div class="h5 text-center">年齢 : 25</div>
                    <div class="h5 text-center">趣味 : 野球</div>
                    <div class="h5 text-center">住所 : 東京</div>
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
}
</script>

<style lang="scss" scoped>

</style>