<!DOCTYPE html>
<html lang="ru">
<head>
	<meta property="og:image" content="https://h-rp.su/meta_img.jpg"/>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="shortcut icon" href="../resource/img/favicon.ico?v=<?php echo $ci;?>" type="image/x-icon">
	<link rel="shortcut icon" href="../resource/img/favicon.gif?v=<?php echo $ci;?>" type="image/gif">
	<link rel="shortcut icon" href="../resource/img/favicon.png?v=<?php echo $ci;?>" type="image/png">
	<link rel="stylesheet" href="../resource/css/index.css?v=<?php echo $ci;?>">
	<link rel="stylesheet" href="../resource/datatables/dataTables.bootstrap4.css?v=<?php echo $ci;?>">
	<link rel="stylesheet" href="../resource/css/sweetalert2.css?v=<?php echo $ci;?>" type="text/css" media="all" />
	<link rel="stylesheet" href="../resource/css/owl.carousel.css?v=<?php echo $ci;?>" type="text/css" />
	<link rel="stylesheet" href="../resource/css/owl.theme.default.css?v=<?php echo $ci;?>" type="text/css" />
	<link rel="stylesheet" href="../resource/css/MarcTooltips.css?v=<?php echo $ci;?>" type="text/css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script src="https://kit.fontawesome.com/b8f783e123.js" crossorigin="anonymous"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="../resource/js/sweetalert2.min.js?v=<?php echo $ci;?>"></script>
	<script src="../resource/js/owl.carousel.js?v=<?php echo $ci;?>"></script>
	<script src="../resource/js/MarcTooltips.js?v=<?php echo $ci;?>"></script>
	<script src="../resource/js/jquery-3.5.1.min.js?v=<?php echo $ci;?>"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123123-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-123123-1');
	</script>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
		ym(66136783, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/66135959" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

	<script>new WOW().init();</script>
	<title>SAMP: Honest Role Play <?PHP
	switch($_SESSION['CURRENT_PAGE'])
	{
		case 1:
		{
			echo '| Играй в GTA: San Andreas по сети';
			break;
		}
		case 2:
		{
			echo '| Новости';
			break;
		}
		case 3:
		{
			echo '| Донат';
			break;
		}
		case 4:
		{
			echo '| Мониторинг';
			break;
		}
		case 5:
		{
			echo '| Личный кабинет';
			break;
		}
		case 6:
		{
			echo '| Успешный платеж';
			break;
		}
		case 7:
		{
			echo '| Не успешный платеж';
			break;
		}
		case 8:
		{
			echo '| Администраторский раздел';
			break;
		}
		case 9:
		{
			echo '| Страница не найдена';
			break;
		}
		case 15:
		{
			echo '| Карта штата';
			break;
		}
	}
	?></title>
</head>
<body>