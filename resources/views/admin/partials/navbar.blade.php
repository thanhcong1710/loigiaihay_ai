<?php

use App\Providers\UtilityServiceProvider as u;
use App\Models\Admin\Admin;

$user_info = Admin::getUserInfo();
$nav_items = u::getDataNavbar();
?>
<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
	<!--begin::Menu-->
	<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
		<!--begin:Menu item-->
		@foreach($nav_items AS $item)
		@if($item['link']=='link_1')
		<!--begin:Menu item-->
		<a href="{{route('admin.loigiai.level',['level_id'=>$item['data_route']])}}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
			<!--begin:Menu link-->
			<span class="menu-link">
				<span class="menu-title">{{$item['title']}}</span>
				<span class="menu-arrow d-lg-none"></span>
			</span>
			<!--end:Menu link-->
		</a>
		<!--end:Menu item-->
		@endif
		@endforeach
	</div>
	<!--end::Menu-->
</div>
<!--end::Menu wrapper-->

<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
	<div class="app-navbar-item ms-1 ms-md-3">
		<!--begin::Drawer toggle-->
		<div class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-60px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
			{{$user_info->coins}} <i class="fa-solid fa-gem vip"></i>
		</div>
		<!--end::Drawer toggle-->
	</div>
	<div class="app-navbar-item ms-1 ms-md-3">
		<!--begin::Drawer toggle-->
		<div class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-60px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
			{{$user_info->coins_free}} <i class="fa-solid fa-gem free"></i>
		</div>
		<!--end::Drawer toggle-->
	</div>
	<!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
		<!--begin::Menu wrapper-->
		<div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
			<img src="/images/avatar_default.png" style="border-radius: 50%;border: solid 1px;" alt="user" />
		</div>
		<!--begin::User account menu-->
		<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
			<!--begin::Menu item-->
			<div class="menu-item px-3">
				<div class="menu-content d-flex align-items-center px-3">
					<!--begin::Avatar-->
					<div class="symbol symbol-50px me-5">
						<img alt="Logo" style="border-radius: 50%;border: solid 1px;" src="/images/avatar_default.png" />
					</div>
					<!--end::Avatar-->
					<!--begin::Username-->
					<div class="d-flex flex-column">
						<div class="fw-bold d-flex align-items-center fs-5">{{$user_info->full_name}}</div>
						<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{$user_info->username}}</a>
					</div>
					<!--end::Username-->
				</div>
			</div>
			<!--end::Menu item-->
			<!--begin::Menu separator-->
			<div class="separator my-2"></div>
			<!--end::Menu separator-->
			<!--begin::Menu item-->
			<div class="menu-item px-5 my-1">
				<a href="{{ route('admin.user.info') }}" class="menu-link px-5">Thông tin tài khoản</a>
			</div>
			<div class="menu-item px-5 my-1">
				<a href="{{ route('admin.payment.list') }}" class="menu-link px-5">Lịch sử giao dịch</a>
			</div>
			<!--end::Menu item-->
			<!--begin::Menu item-->
			<div class="menu-item px-5">
				<a href="{{ route('admin.logout') }}" class="menu-link px-5">Đăng xuất</a>
			</div>
			<!--end::Menu item-->
		</div>
		<!--end::User account menu-->
		<!--end::Menu wrapper-->
	</div>
	<!--end::User menu-->
	<!--begin::Header menu toggle-->
	<div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
		<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
			<!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
			<span class="svg-icon svg-icon-1">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
					<path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
	</div>
	<!--end::Header menu toggle-->
</div>