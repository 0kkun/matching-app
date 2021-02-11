<template>
    <div class="container">
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
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style lang="scss" scoped>
</style>
