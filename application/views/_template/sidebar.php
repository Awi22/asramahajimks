<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
						<!--begin::Logo-->
						<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
							<!--begin::Logo image-->
							<a href="<?=base_url()?>">
								<img alt="Logo" src="<?=base_url()?>public/assets/media/logos/wuling-logo-horizontal-white.png" class="h-25px app-sidebar-logo-default" />
								<img alt="Logo" src="<?=base_url()?>public/assets/media/logos/wuling-logo-single-white.png" class="h-20px app-sidebar-logo-minimize" />
							</a>
							<!--end::Logo image-->

							<!--begin::Sidebar toggle-->
							<!--begin::Minimized sidebar setup: -->
							<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
								<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<?php
								if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") : ?> 
									<script>
										document.getElementById('kt_app_body').setAttribute('data-kt-app-sidebar-minimize', 'on');
										document.getElementById('kt_app_body').setAttribute('data-kt-toggle-state', 'active');
										document.getElementById('kt_app_sidebar_toggle').classList.add("active")
										document.getElementById('kt_app_sidebar_toggle').setAttribute('data-kt-toggle-state', 'active');
									</script>
								<?php endif ?>
							<!--end::Sidebar toggle-->
						</div>
						<!--end::Logo-->

						<!--begin::sidebar menu-->
						<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
							<!--begin::Menu wrapper-->
							<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
								<!--begin::Scroll wrapper-->
								<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
									<!--begin::Menu-->
									<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
										<!--begin:Menu item-->
										
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="<?=base_url()?>" >
												<span class="menu-icon">
													<i class="ki-duotone ki-code fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
													</i>
												</span>
												<span class="menu-title">HOME</span>
											</a>
											<!--end:Menu link-->
										</div>

										<?php
										// $this->load->model('model_menu');
										// $menu_items = $this->model_menu->generate_menu();
										// echo $menu_items;
										echo $menu_items;
										?>
									</div>
									<!--end::Menu-->
								</div>
								<!--end::Scroll wrapper-->
							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::sidebar menu-->
					</div>
