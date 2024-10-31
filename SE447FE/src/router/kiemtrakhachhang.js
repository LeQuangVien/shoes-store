import axios from 'axios';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default function (to, from, next) {
    axios
        .post('http://127.0.0.1:8000/api/khach-hang/check-login', {}, {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('chia_khoa_16')
            }
        })
        .then((res) => {
            if (res.data.status) {
                next();
            } else {
                next('/sign-in');
                toaster.error('Thông báo<br>' + res.data.message);
            }
        })
        .catch(() => {
            next('/sign-in');
            toastr.error("Bạn phải đăng nhập nhé!");
        })
}