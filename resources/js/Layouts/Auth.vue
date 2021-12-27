<template>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div
    id="main-wrapper"
    data-layout="vertical"
    data-navbarbg="skin5"
    data-sidebartype="full"
    data-sidebar-position="absolute"
    data-header-position="absolute"
    data-boxed-layout="full"
  >
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <Link class="navbar-brand" :href="route('dashboard')">
            <b class="logo-text text-success mx-md-auto px-2"> Saekedelai </b>
          </Link>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <a
            class="
              nav-toggler
              waves-effect waves-light
              text-dark
              d-block d-md-none
            "
            href="javascript:void(0)"
            ><i class="fa fa-bars"></i
          ></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div
          class="navbar-collapse collapse"
          id="navbarSupportedContent"
          data-navbarbg="skin5"
        >
          <!-- ============================================================== -->
          <!-- Right side toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav ms-auto d-flex align-items-center">
            <!-- ============================================================== -->
            <!-- Search -->
            <!-- ============================================================== -->
            <!-- <li class="in">
              <form role="search" class="app-search d-none d-md-block me-3">
                <input
                  type="text"
                  placeholder="Search..."
                  class="form-control mt-0"
                />
                <a href="" class="active">
                  <i class="fa fa-search"></i>
                </a>
              </form>
            </li> -->
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ $page.props.auth.user.name }}
                <i class="fa fa-chevron-down"></i>
              </a>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="navbarDropdown"
              >
                <li>
                  <Link class="dropdown-item" :href="route('profile.index')"
                    >Profile</Link
                  >
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <Link
                    method="post"
                    as="button"
                    class="dropdown-item"
                    :href="route('logout')"
                  >
                    Logout</Link
                  >
                </li>
              </ul>
            </li>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
      <!-- Sidebar scroll-->
      <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
          <ul id="sidebarnav">
            <!-- User Profile-->
            <li class="sidebar-item pt-2">
              <Link
                class="sidebar-link waves-effect waves-dark"
                :class="{ active: route().current('dashboard') }"
                :href="route('dashboard')"
                aria-expanded="false"
              >
                <i class="far fa-clock" aria-hidden="true"></i>
                <span class="hide-menu">Dashboard</span>
              </Link>
            </li>
            <li class="sidebar-item pt-2">
              <Link
                v-if="$page.props.policy['organization.viewAny']"
                class="sidebar-link waves-effect waves-dark"
                :class="{ active: route().current('organization.index') }"
                :href="route('organization.index')"
                aria-expanded="false"
              >
                <i class="fa fa-users" aria-hidden="true"></i>
                <span class="hide-menu">Kelompok tani</span>
              </Link>
            </li>
            <li class="sidebar-item pt-2">
              <Link
                v-if="$page.props.policy['user.viewAny']"
                class="sidebar-link waves-effect waves-dark"
                :class="{ active: route().current('user.index') }"
                :href="route('user.index')"
                aria-expanded="false"
              >
                <i class="far fa-user" aria-hidden="true"></i>
                <span class="hide-menu">Pengguna</span>
              </Link>
            </li>
            <div class="px-4 d-md-none">
                <hr>
            </div>
            <li class="sidebar-item pt-2 d-md-none">
              <Link
                class="sidebar-link waves-effect waves-dark "
                :class="{ active: route().current('profile.index') }"
                :href="route('profile.index')"
                aria-expanded="false"
              >
                <i class="far fa-clock" aria-hidden="true"></i>
                <span class="hide-menu">Profile</span>
              </Link>
            </li>
            <li class="sidebar-item pt-2 d-md-none">
              <Link
                class="sidebar-link waves-effect waves-dark "
                :href="route('logout')"
                method="post"
                as="button"
                aria-expanded="false"
              >
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                <span class="hide-menu">Logout</span>
              </Link>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h4 class="page-title">
              <slot name="header" />
            </h4>
          </div>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <main>
          <slot />
        </main>
      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <footer class="footer text-center">
        2021 © Ample Admin brought to you by
        <a href="https://www.wrappixel.com/">wrappixel.com</a>
      </footer>
      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },
  mounted() {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function() {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("fa-times");
    });

    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
        $(".app-search input").focus();
    });

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //****************************
    var setsidebartype = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        if (width < 991) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);
  },
};
</script>

<style>
.logo-text {
  font-size: 1.7rem;
}
</style>
