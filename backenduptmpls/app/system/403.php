<!DOCTYPE html>
<html lang="ru">
	<head>

		<title>Вход в свой профиль – uptime+</title>
		<meta charset="utf-8" />
	
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	
		<link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
		
		<link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/style.bundle.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />
		
	</head>
	<body id="kt_body" class="app-blank app-blank">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center" style="background-image: url(/assets/media/misc/auth-bg.png)">
					<div class="d-flex flex-column flex-center p-6 p-lg-10 w-100">
						<a href="https://uptime.plus/" class="mb-0 mb-lg-20">
							<img alt="Logo" src="/assets/media/logos/default-white.svg" class="h-40px h-lg-50px" />
						</a>
						<img class="d-none d-lg-block mx-auto w-300px w-lg-75 w-xl-300px mb-10 mb-lg-20" src="/assets/media/misc/auth-screens.png" alt="" />
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bold text-center mb-7">Мониторинг сайта и API</h1>
						
						<div class="d-none d-lg-block text-white fs-lg text-center">Сервис  <span class="text-warning fw-semibold me-1">uptime+</span>позволяет в режиме реального времени следить за своим сайтом, сервисом или API. <br />
							Бывают разные ситуации, а вдруг сервер упал или деплой неудачный? <br /><br />Мы увидим и оповестим вас об этом в тот же час 😉</div>
					</div>
				</div>
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10">
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<div class="w-lg-500px p-10">
							<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="index.html" action="#">
								<div class="text-center mb-11">
									<h1 class="text-gray-900 fw-bolder mb-3">Вход</h1>
									<div class="text-gray-500 fw-semibold fs-6">в свой профиль</div>
								</div>
								
								<div class="fv-row mb-8">
									<input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
								</div>
								<div class="fv-row mb-3">
									<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
								</div>
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
									<a href="/forgot" class="link-primary">Забыли пароль?</a>
								</div>
								<div class="d-grid mb-10">
									<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
										<span class="indicator-label">Войти</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<div class="text-gray-500 text-center fw-semibold fs-6">Еще не с нами? 
								<a href="/signup" class="link-primary">Хочу зарегистрироваться</a></div>
							</form>
						</div>
					</div>

					<div class="d-flex flex-center flex-wrap px-5">
						<div class="d-flex fw-semibold text-primary fs-base">
							<a href="https://uptime.plus/terms" class="px-5" target="_blank">Правила использования</a>
							<a href="https://uptime.plus/tariffs" class="px-5" target="_blank">Тарифы</a>
							<a href="https://uptime.plus/contacts" class="px-5" target="_blank">Контакты</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script>var hostUrl = "/assets/";</script>
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		
		<script src="/assets/js/custom/authentication/sign-in/general.js"></script>
	</body>
	<!--end::Body-->
</html>