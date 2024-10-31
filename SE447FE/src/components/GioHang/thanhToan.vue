<template>
    <div style="text-align: center; margin-top: -100px;">
        <h4 style="font-size: 50px; margin-bottom: 40px; color: gray;">Thanh Toán</h4>
    </div>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-4" style="margin-top: -39px;">
                    <h5>Nhập Địa Chỉ Bạn Muốn Giao Hàng*</h5>
                    <hr>
                    <div>
                        <label for="">Họ Tên*</label>
                        <input v-model="create_address.ten_nguoi_nhan" type="text" class="form-control"
                            placeholder="Nhập Họ Và Tên">
                    </div>
                    <div class="mt-3">
                        <label for="">Số Điện Thoại*</label>
                        <input v-model="create_address.so_dien_thoai" type="text" class="form-control"
                            placeholder="Nhập Số Điện Thoại" required>
                    </div>
                    <div class="mt-3">
                        <label for="">Nhập Địa Chỉ Cụ Thể*</label>
                        <input v-model="create_address.dia_chi" type="text" class="form-control"
                            placeholder="Nhập Địa Chỉ" required>
                    </div>
                    <div class="mt-3">
                        <label for="">Email*</label>
                        <input v-model="create_address.email" type="text" class="form-control" placeholder="Nhập Email"
                            required>
                    </div>
                    <div class="mt-3">
                        <label for="">Ghi Chú</label>
                        <textarea v-model="create_address.ghi_chu" class="form-control">
                        </textarea>
                    </div>
                    <button v-on:click="createAddress()" class="btn btn-danger mt-3">Xác Nhận Địa Chỉ Nhận Hàng</button>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="background-color: gainsboro;">
                        <div class="title-thanhtoan mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <b style="margin-left: 10px;">Ấn Chon Xác Nhận Tổng Sản Phẩm</b>
                                </div>
                                <div class="col-4">
                                    <router-link to="/gio-hang">
                                        <button class="btn btn-primary">Quay Lại</button>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-header">
                            <template v-for="(value, index) in list_select" :key="value">
                                <div class="content-thanhtoan">
                                    <input v-on:change="total()" v-model="value.chon_sp" class="form-check-input me-3"
                                        type="checkbox" value="" aria-label="...">
                                    <b style="font-size: 18px; color: black;">{{ value.ten_san_pham }}</b>
                                    <p class="para-4">Giá: {{ formatToUSD(value.thanh_tien) }}</p>
                                    <div class="d-flex justify-content-between">
                                        <p class="para-4">Số lượng: {{ value.so_luong }}</p>
                                        <button class="btn btn-danger" style="margin-right: 40px;"
                                            v-on:click="deletePayed(value)">Xóa</button>
                                    </div>
                                </div>
                                <hr>
                            </template>
                        </div>
                        <div class="card-body">
                            <p class="para-4">Giảm Giá: $0</p>
                            <p class="" style="color: red;">Tổng: {{ formatToUSD(total_amount) }}</p>
                            <b></b>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-footer">
                        <div class="form-check">
                            <input v-model="is_thanh_toan" value="0" class="form-check-input" type="radio" name="option"
                                id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                <b> Chuyển khoản ngân hàng</b>
                                <p style="text-align: justify;">Thực Hiện Thanh Toán Vào Ngay Tài Khoản Ngân Hàng Của
                                    Chúng Tôi. Đơn
                                    Hàng Của Bạn Được Gửi Qua Email Nhằm Xác Thực Thanh Toán.
                                </p>
                                <p style="color: red; margin-top: -10px;">*Vui Lòng
                                    Vào Email Để Xác
                                    Thực!</p>
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input v-model="is_thanh_toan" value="1" class="form-check-input" type="radio" name="option"
                                id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                <b>Trả tiền mặt khi nhận hàng</b>
                            </label>
                        </div>
                    </div>
                    <div class="content-thanhtoan text-end me-5 mb-3">
                        <button v-on:click="buyProductVNP()" type="button" class="btn btn-danger"> Thanh Toán
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from '../../core/baseRequest'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            list_select: {},
            total_amount: 0,
            create_address: {},
            is_thanh_toan: '',
        }
    },
    mounted() {
        this.listProductPayed();
    },
    methods: {
        formatToUSD(number) {
            number = parseInt(number);
            return number.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        },
        listProductPayed() {
            baseRequest
                .get('gio-hang/gio-hang-thanh-toan')
                .then((res) => {
                    this.list_select = res.data.data
                })
        },
        total() {
            let tmp = 0;
            this.list_select.forEach((value, index) => {
                if (value.chon_sp == true) {
                    tmp = tmp + value.thanh_tien;
                }
            })
            this.total_amount = tmp;
        },
        deletePayed(value) {
            baseRequest
                .post('gio-hang/delete/thanh-toan', value)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông Báo<br>" + res.data.message);
                        this.listProductPayed();
                    } else {
                        toaster.error("Thông Báo<br>" + res.data.message);
                    }
                })
        },
        createAddress() {
            baseRequest
                .post('dia-chi/create', this.create_address)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông Báo<br>" + res.data.message);
                    } else {
                        toaster.error("Thông Báo<br>" + res.data.message);
                    }
                })
        },

        buyProductVNP() { /*mất 3h fix*/
            var list_chon = [];
            this.list_select.forEach((value, key) => {
                if (value.chon_sp && value.chon_sp == true) {
                    list_chon.push(value);
                }
            });
            var payload = {
                'ds_mua_sp': list_chon,
                'chon_thanh_toan': this.is_thanh_toan,
            }

            baseRequest
                .post('don-hang/thanh-toan-VNP', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        this.total_amount = 0,
                            this.listProductPayed();
                        this.list_select = {}
                        //    this.create_address = {}
                    } else {
                        toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        },
    },
}
</script>
<style></style>