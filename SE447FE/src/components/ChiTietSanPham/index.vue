<template>
    <header class="site-header section-padding d-flex justify-content-center align-items-center"
        style="margin-top: -10%;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12">
                    <h1>
                        <span class="d-block text-danger" style="font-size: 100px; margin-left: 50px;">We provide
                            you</span>
                        <span class="d-block text-dark" style="margin-left: 150px;">Fashionable Stuffs</span>
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <section class="product-detail section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="product-thumb">
                        <img v-bind:src="product_detail.hinh_anh" class="img-fluid product-image" alt="">
                    </div>
                    <hr>
                    <div>
                        <img class="img-fluid product-image"
                            src="https://cdn.duvis.vn/post/xem-ki-huong-dan-ve-size-giay-312358.jpeg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="product-info d-flex">
                        <div>
                            <h2 class="product-title mb-0">{{ product_detail.ten_san_pham }}</h2>
                            <div class="d-flex align-items-center mt-3 fs-6">
                                <div class="stars">
                                    <i class="bx bxs-star text-secondary"></i>
                                    <i class="bx bxs-star text-secondary"></i>
                                    <i class="bx bxs-star text-secondary"></i>
                                    <i class="bx bxs-star text-secondary"></i>
                                    <i class="bx bxs-star text-secondary"></i>
                                </div>
                                <p class="mb-0" style="margin-left: 20px; font-size: 13px;"><a href="">0 <span>đánh
                                            giá</span></a></p>
                            </div>
                            <p class="product-p"></p>
                            <small style="font-size: 20px; color: red;" class="product-price ms-auto mt-auto mb-5">{{
                                formatToUSD(product_detail.gia_khuyen_mai) }}</small>
                            <small style="font-size: 15px; margin-left: 15px;"
                                class="product-price text-decoration-line-through text-secondary">{{
                                    formatToUSD(product_detail.gia_ban) }}</small>
                        </div>
                    </div>

                    <div class="product-description">
                        <strong class="d-block mb-2 text-danger" style="font-size: 20px;">Mô Tả</strong>
                        <p class="lead mb-5">{{ product_detail.mo_ta_ngan }}</p>
                    </div>
                    <div class="product-cart-thumb row">
                        <div class="col-lg-6 col-12">
                            <select class="form-select cart-form-select" id="inputGroupSelect01">
                                <option selected>Quantity</option>
                                <option value="1">42</option>
                                <option value="2">43</option>
                                <option value="3">44</option>
                                <option value="4">45</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                            <template v-if="is_login == true">
                                <button v-on:click="CreateShoppingCart()" type="button"
                                    class="btn btn-danger custom-btn cart-btn" data-bs-toggle="modal"
                                    data-bs-target="#cart-modal">Thêm vào giỏ hàng</button>
                            </template>
                            <template v-else>
                                <router-link to="/sign-in">
                                    <button type="button" class="btn btn-danger custom-btn cart-btn"
                                        data-bs-toggle="modal" data-bs-target="#cart-modal">Thêm vào giỏ hàng</button>
                                </router-link>
                            </template>
                        </div>
                    </div>
                    <hr>
                    <div class="product-description">
                        <strong class="d-block mb-2 text-danger" style="font-size: 20px;">Mô Tả Chi Tiết</strong>
                        <p class="lead mb-2">{{ product_detail.mo_ta_thu_nhat }}</p>
                        <p class="lead mb-2">{{ product_detail.mo_ta_thu_hai }}</p>
                        <p class="lead mb-2">{{ product_detail.mo_ta_thu_ba }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="related-product section-padding border-top">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h3 class="mb-5">You might also like</h3>
                </div>

                <template v-for="(value, index) in list_detail" :key="index">
                    <div class="col-lg-4 col-12 mb-3">
                        <router-link :to="'/chi-tiet-san-pham/' + value.id + '-' + value.slug_san_pham">
                            <div class="product-thumb">
                                <a href="product-detail.html">
                                    <img style="width: 450px;" v-bind:src="value.hinh_anh"
                                        class="img-fluid product-image" alt="">
                                </a>

                                <div class="product-top d-flex">
                                    <span class="product-alert me-auto">New arrival</span>

                                    <a href="#" class="bi-heart-fill product-icon"></a>
                                </div>

                                <div class="product-info d-flex" style="height: 255px;">
                                    <div>
                                        <div style="height: 200px;">
                                            <h5 class="product-title mb-0">
                                                <a href="product-detail.html" class="product-title-link">{{
                                                    value.ten_san_pham
                                                }}</a>
                                            </h5>
                                            <p class="product-p" style="text-align: justify;">{{ value.mo_ta_ngan }}
                                            </p>
                                        </div>
                                        <div class="row" style="margin-top: -30px;">
                                            <div class="col-7">
                                                <small style="font-size: 17px;"
                                                    class="product-price text-muted ms-auto mt-auto mb-5"><span
                                                        style="color: red;">Giá
                                                        Khuyến Mãi</span>: {{
                                                            value.gia_khuyen_mai
                                                        }}$</small>
                                            </div>
                                            <div class="col-5">
                                                <small style="font-size: 17px;"
                                                    class="product-price text-decoration-line-through text-muted ms-auto mt-auto mb-5"><span>Giá
                                                        Gốc: </span>{{
                                                            value.gia_ban
                                                        }}$</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>
<script>
import baseRequest from '../../core/baseRequest';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
export default {
    props: ['id_san_pham', 'slug_san_pham'],
    data() {
        return {
            id_san_pham: null,
            product_detail: {},
            list_detail: [],
            is_login: false,
        }
    },
    mounted() {
        this.id_san_pham = this.$route.params.id_san_pham;
        this.ProductDetail();
        this.ListDetail();
        this.checkLogin();
    },
    beforeRouteUpdate(to, from, next) {
        this.id_san_pham = to.params.id_san_pham;
        this.ProductDetail();
        next();
    },
    methods: {
        ProductDetail() {
            baseRequest
                .get('san-pham/san-pham-chi-tiet/select/' + this.id_san_pham)
                .then((res) => {
                    this.product_detail = res.data.data;
                })
        },
        ListDetail() {
            baseRequest
                .get('trang-chu/san-pham/select')
                .then((res) => {
                    this.list_detail = res.data.newArrivals;
                })
        },
        checkLogin() {
            baseRequest
                .post('khach-hang/check-login')
                .then((res) => {
                    if (res.data.status) {
                        this.is_login = true;
                    }
                })
        },
        CreateShoppingCart() {
            var payload = {
                'id_san_pham': this.id_san_pham
            };
            baseRequest
                .post('chi-tiet-don-hang/them-vao-gio-hang', payload)
                .then((res) => {
                    if (res.data.status) {
                        toaster.success("Thông Báo <br>" + res.data.message);
                    } else {
                        toaster.error("Thông Báo <br>" + res.data.message);
                    }
                })
        },
        formatToUSD(number) {
            number = parseInt(number);
            return number.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        },

    },
}
</script>
<style></style>