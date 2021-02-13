<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div class="card m-3 p-3">
                    <div class="input-group pr-5 pl-5">
                        <input type="text" class="form-control" placeholder="Please input keywords..." aria-label="Please input keywords..." aria-describedby="button-addon">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="/images/cat1.jpeg">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <div>佐藤</div>
                                    <p>初めまして</p>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="images/cat1.jpeg">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <div>佐藤</div>
                                    <p>初めまして</p>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="images/cat1.jpeg">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <div>佐藤</div>
                                    <p>初めまして</p>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></a>
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
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style lang="scss" scoped>
</style>
