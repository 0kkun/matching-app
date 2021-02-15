<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 pt-3">
                <SideBar />
            </div>

            <div class="col-sm-9">
                <div class="card mt-3 mb-3 pt-3 pb-3">
                    <div class="input-group pr-5 pl-5">
                        <input type="text" class="form-control" placeholder="Please input keywords..." aria-label="Please input keywords..." aria-describedby="button-addon">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-columns pl-2">
                    <div v-for="user in users" :key="user.id">
                        <div class="card" style="height:290px; width:250px;">
                            <div v-if="user.profile.image_name=='no_image.png'">
                                <img class="card-img-top" style="max-height:200px;" src="/images/default/no_image.png">
                            </div>
                            <div v-else>
                                <img class="card-img-top" style="max-height:200px;" :src="'/images/uploads/' + user.profile.image_name">
                            </div>
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <div>{{ user.name }}</div>
                                    <p>{{ user.profile.tweet }}</p>
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
