<template>
    <div class="container">
        <div class="row">

            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div>ゲストさん</div>
                <div>画像</div>
                <div>一言 : </div>
                <div>自己紹介</div>
                <div>年齢 : </div>
                <div>趣味 : </div>
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