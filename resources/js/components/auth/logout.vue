<template>

</template>

<script>
    export default {
        created() {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            Toast.fire({
                icon: 'success',
                title: 'Logged out successfully'
            })
            this.$router.push({
                name: '/'
            })
        }
    }
</script>

<style>

</style>
