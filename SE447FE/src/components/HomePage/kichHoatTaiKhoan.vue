<template>
    <router-link to="/sign-in">
        <button class="btn btn-primary">Back</button>
    </router-link>

</template>
<script>
import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
import baseRequest from '../../core/baseRequest';
export default {
    props: ['id_can_kich_hoat'],
    mounted() {
        this.kichHoatTaiKhoan();
    },
    methods: {
        kichHoatTaiKhoan() {
            baseRequest
                .get('kich-hoat-tai-khoan/' + this.$route.params.id_can_kich_hoat)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success(res.data.message);
                    } else {
                        toaster.error(res.data.message);
                    }
                })
        }
    },
}
</script>
<style></style>