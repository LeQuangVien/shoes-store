<template>
    <div class="container">
        <div class="row">
            <div class="col-12" style="margin-top: -70px;">
                <h4 class="text-center" style="font-size: 40px; color: gray; margin-bottom: 20px;">Giỏ Hàng</h4>
                <table class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th></th>
                            <th>stt</th>
                            <th>Ảnh Đại Diện</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Size</th>
                            <th>Đơn Giá</th>
                            <th>Thành Tiền</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(value, index) in List_shoppingCart" :key="index">
                            <tr class="align-middle" style="height: 185px;">
                                <td class="align-middle text-center">
                                    <input v-on:change="totalProduct()" v-model="value.chon_sp"
                                        class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                </td>
                                <th class="align-middle text-center">{{ value.id }}</th>
                                <td class="align-middle text-center"><img class="img-fluid"
                                        style="width: 120px; height: 120px" v-bind:src="value.hinh_anh" alt=""></td>
                                <td class="align-middle text-center">{{ value.ten_san_pham }}</td>
                                <td style="width: 140px;" class="align-middle">
                                    <div class="input-group input-spinner d-flex justify-content-center flex-row"
                                        style="flex-wrap: nowrap;">
                                        <button v-on:click="value.so_luong--; updateShoppingCart(value)"
                                            class="btn btn-dark" type="button" id="button-minus"> − </button>
                                        <input v-model="value.so_luong" v-on:change="updateShoppingCart(value)"
                                            type="text" class="form-control text-center">
                                        <button v-on:click="value.so_luong++; updateShoppingCart(value)"
                                            class="btn btn-dark" type="button" id="button-plus"> + </button>
                                    </div>
                                </td>
                                <td style="width: 140px;" class="align-middle">
                                    <div class="input-group input-spinner d-flex justify-content-center flex-row"
                                        style="flex-wrap: nowrap;">
                                        <button v-on:click="value.size--; updateShoppingCart(value)"
                                            class="btn btn-dark" id="button-minus"> − </button>
                                        <input v-model="value.size" v-on:keyup="updateShoppingCart(value)" type="text"
                                            class="form-control text-center">
                                        <button v-on:click="value.size++; updateShoppingCart(value)"
                                            class="btn btn-dark" type="button" id="button-plus"> + </button>
                                    </div>
                                </td>
                                <td class="align-middle text-center">{{ formatToUSD(value.don_gia) }}</td>
                                <td class="align-middle text-center">{{ formatToUSD(value.thanh_tien) }}</td>
                                <td class="align-middle text-center">
                                    <div>
                                        <button v-on:click="deleteShoppingCart(value)"
                                            class="btn btn-danger me-3">Xóa</button>
                                    </div>
                                </td>
                            </tr>


                        </template>
                    </tbody>
                </table>
            </div>
            <div class="col-8">
            </div>
            <div class="col-lg-4">
                <div class="card tongtien" style="background-color: gainsboro;">
                    <div class="card-header">
                        <div class="title-thanhToan">
                            <b>Tổng giỏ hàng</b>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content text-end">
                            <p class="para-giohang">Tạm Tính</p>
                            <b class="para-giohang" style="color: black; font-size: 25px;">{{ formatToUSD(total_amount)
                                }}</b>
                            <p class="para-giohang">Giảm Giá</p>
                            <b class="para-giohang" style="color: black; font-size: 25px;">{{
                                formatToUSD(total_promotion)
                            }}</b>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="thanhtien text-end">
                            <b style="font-size: 20px;">Tổng: </b>
                            <b style="font-size: 20px; color: red;"> {{ formatToUSD(total_amount)
                                }}</b>
                            <div>
                                <router-link to="/thanh-toan">
                                    <button v-on:click="buyProduct()" class="btn btn-danger mb-3 mt-3">Thanh Toán
                                        Ngay</button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    data() {
        return {
            List_shoppingCart: [],
            total_amount: 0,
            total_promotion: 0,
        }
    },
    mounted() {
        this.callShoppingCart();
    },
    methods: {
        callShoppingCart() {
            baseRequest
                .get('chi-tiet-don-hang/select-gio-hang')
                .then((res) => {
                    this.List_shoppingCart = res.data.data
                })
        },
        deleteShoppingCart(value) {
            baseRequest
                .post('chi-tiet-don-hang/delete-san-pham-gio-hang', value)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông Báo<br>" + res.data.message);
                        this.callShoppingCart();
                    } else {
                        toaster.success("Thông Báo<br>" + res.data.message);
                    }
                })
        },

        updateShoppingCart(value) {
            baseRequest
                .post('chi-tiet-don-hang/update-gio-hang', value)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông Báo <br>" + res.data.message);
                        this.callShoppingCart();
                    } else {
                        toaster.error("Thông Báo <br>" + res.data.message);
                    }
                })
        },
        formatToUSD(number) {
            number = parseInt(number);
            return number.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        },
        totalProduct() {
            let tmp = 0;
            this.List_shoppingCart.forEach((value, index) => {
                if (value.chon_sp == true) {
                    tmp = tmp + value.thanh_tien;
                }
            })
            this.total_amount = tmp;
        },
        buyProduct() {
            var list_chon = [];
            this.List_shoppingCart.forEach((value, key) => {
                if (value.chon_sp && value.chon_sp == true) {
                    list_chon.push(value);
                }
            });
            var payload = {
                'ds_mua_sp': list_chon,
            };
            baseRequest
                .post('gio-hang/list-chon-san-pham', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success('Thông báo<br>' + res.data.message);
                        alert("Đây là một cảnh báo");
                        // this.loadDataGioHang();
                    } else {
                        // toaster.error('Thông báo<br>' + res.data.message);
                    }
                });
        }
    },
}
</script>
<style></style>