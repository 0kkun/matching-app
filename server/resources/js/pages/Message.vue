<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>
            <div class="col-sm-9">
                <div>
                    Message Page
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