<template>
    <div class="nav-container primary-menu">
        <div class="mobile-topbar-header">
            <div>
                <img src="../../assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text">Rukada</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl w-100">
            <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                <li class="nav-item">
                    <router-link to="/admin/tai-khoan/khach-hang">
                        <a class="nav-link" href="/admin/tai-khoan/khach-hang">
                            <div class="parent-icon"><i class="fa-brands fa-product-hunt"></i>
                            </div>
                            <div class="menu-title">Khách Hàng</div>
                        </a>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/don-hang">
                        <a class="nav-link" href="/admin/don-hang">
                            <div class="parent-icon"><i class="fa-brands fa-product-hunt"></i>
                            </div>
                            <div class="menu-title">Đơn Hàng</div>
                        </a>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/san-pham">
                        <a class="nav-link" href="/admin/san-pham">
                            <div class="parent-icon"><i class="fa-brands fa-product-hunt"></i>
                            </div>
                            <div class="menu-title">Sản Phẩm</div>
                        </a>
                    </router-link>
                </li>
                <!-- <li class="nav-item">
                    <router-link to="/admin">
                        <a class="nav-link" href="/admin">
                            <div class="parent-icon"><i class="fa-brands fa-product-hunt"></i>
                            </div>
                            <div class="menu-title">Danh Mục</div>
                        </a>
                    </router-link>
                </li> -->
            </ul>
        </nav>
    </div>
</template>
<script>
export default {

}
</script>
<style></style>