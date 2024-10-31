import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });
import kiemTraKhachHang from './kiemtrakhachhang';
import kiemTraNhanVien from './kiemtranhanvien';
const routes = [
    {
        path: '/',
        component: () => import('../components/HomePage/TrangChu.vue'),
        meta: { layout: 'client' }
    },
    {
        path: '/about',
        component: () => import('../components/About/about.vue'),
        meta: { layout: 'client' }
    },
    {
        path: '/product',
        component: () => import('../components/Product/product.vue'),
        meta: { layout: 'client' }
    },
    {
        path: '/faq',
        component: () => import('../components/FaQ/faq.vue'),
        meta: { layout: 'client' }
    },
    {
        path: '/contact',
        component: () => import('../components/Contact/contact.vue'),
        meta: { layout: 'client' }
    },
    // auth
    {
        path: '/sign-in',
        component: () => import('../components/signIn/index.vue'),
        meta: { layout: 'auth' }
    },
    {
        path: '/sign-up',
        component: () => import('../components/SignUp/index.vue'),
        meta: { layout: 'auth' }
    },
    // Chi Tiet San Pham
    {
        path: '/chi-tiet-san-pham/:id_san_pham-:slug_san_pham',
        component: () => import('../components/ChiTietSanPham/index.vue'),
        props: true
    },
    // Gio Hang
    {
        path: '/gio-hang',
        component: () => import('../components/GioHang/index.vue'),
        meta: { layout: 'client' },
        beforeEnter: kiemTraKhachHang
    },
    {
        path: '/thanh-toan',
        component: () => import('../components/GioHang/thanhToan.vue'),
        meta: { layout: 'client' },
        beforeEnter: kiemTraKhachHang
    },
    //Profile
    {
        path: '/profile',
        component: () => import('../components/KhachHang/Profile.vue'),
        meta: { layout: 'client' },
        beforeEnter: kiemTraKhachHang
    },


    //DanhMuc
    {
        path: '/danh-sach-san-pham/:id_danh_muc-:slug_danh_muc',
        component: () => import('../components/Product/danhMucSanPham.vue'),
        props: true
    },
    // admin
    // {
    //     path: '/admin',
    //     component: () => import('../components/Admin/index.vue'),
    //     meta: { layout: 'admin' }
    // },

    {
        path: '/admin/tai-khoan/khach-hang',
        component: () => import('../components/Admin/khachHang.vue'),
        meta: { layout: 'admin' },
        beforeEnter: kiemTraNhanVien

    },

    {
        path: '/admin/don-hang',
        component: () => import('../components/Admin/donHang.vue'),
        meta: { layout: 'admin' },
        beforeEnter: kiemTraNhanVien

    },

    {
        path: '/admin/san-pham',
        component: () => import('../components/Admin/sanPham.vue'),
        meta: { layout: 'admin' },
        beforeEnter: kiemTraNhanVien

    },

    {
        path: '/admin',
        component: () => import('../components/Admin/danhMuc.vue'),
        meta: { layout: 'admin' },
        beforeEnter: kiemTraNhanVien

    },

    {
        path: '/admin/login',
        component: () => import('../components/Admin/login.vue'),
        meta: { layout: 'authadmin' },
    },


    // Tìm Kiếm loginer
    {
        path: '/tim-kiem',
        component: () => import('../components/HomePage/timKiemSanPham.vue'),
        meta: { layout: 'client' },
        name: 'timKiem',
        props: true
    },

    {
        path: '/kich-hoat-tai-khoan/:id_can_kich_hoat',
        component: () => import('../components/HomePage/kichHoatTaiKhoan.vue'),
        meta: { layout: 'client' },
        props: true
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router