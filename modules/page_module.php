<?php
$_SESSION['CURRENT_PAGE'] = 0;
switch($Page){
    case 'index':{ $_SESSION['CURRENT_PAGE'] = 1; include('page/index.php'); break; }
    case 'news':{ $_SESSION['CURRENT_PAGE'] = 2; include('page/news.php'); break; }
    case 'donate':{ $_SESSION['CURRENT_PAGE'] = 3; include('page/donate.php'); break; }
    case 'monitoring':{ $_SESSION['CURRENT_PAGE'] = 4; include('page/monitoring/monitoring.php'); break; }
    case 'ucp':{ $_SESSION['CURRENT_PAGE'] = 5; include('page/ucp/ucp.php'); break; }
    case 'success_payment':{ $_SESSION['CURRENT_PAGE'] = 6; include('page/success_payment.php'); break; }
    case 'fail_payment':{ $_SESSION['CURRENT_PAGE'] = 7; include('page/fail_payment.php'); break; }
    case 'adminpanel':{ $_SESSION['CURRENT_PAGE'] = 8; include('page/adminpanel/adminpanel.php'); break; }
    case 'contacts':{ $_SESSION['CURRENT_PAGE'] = 12; include('page/contacts.php'); break; }
    case 'pk':{ $_SESSION['CURRENT_PAGE'] = 13; include('page/pk.php'); break; }
    case 'ls':{ $_SESSION['CURRENT_PAGE'] = 14; include('page/ls.php'); break; }
    case 'statemap':{ $_SESSION['CURRENT_PAGE'] = 15; include('page/statemap.php'); break; }
    case 'uindex':{ include('modules/unitpay/sample/initPaymentForm.php'); break; }
    case 'don':{ include('modules/don.php'); break; }
    case 'qiwipay':{ include('modules/qiwi/pay.php'); break; }
    case 'qiwiout':{ include('modules/qiwi/qiwiout.php'); break; }
    case 'qtest':{ include('modules/qiwi/test.php'); break; }
    case 'uhandler':{ include('modules/unitpay/sample/handler.php'); break; }
    case 'ufunc':{ include('modules/unitpay/sample/functions.php'); break; }
    case 'getitem':{ include('modules/getitem.php'); break; }
    case 'use_item':{ include('modules/use_item.php'); break; }
    case 'sell_item':{ include('modules/sell_item.php'); break; }
    case 'auto_update':{ include('modules/auto_update.php'); break; }
    case 'buyservice':{ include('modules/buyservice.php'); break; }
    case 'getcode':{ include('page/getcode.php'); break; }
    case 'f_online':{ include('scripts/cache/graph_online.cache.php'); break; }
    case 'getonline':{ include('modules/getonline.php'); break; }
    case 'phpinfo':{ include('modules/phpinfo.php'); break; }
    case 'uvk':{ include('modules/vk_sender.php'); break; }
    case 'umail':{ include('resource/sendmail.php'); break; }
    case 'utg':{ include('modules/tg_sender.php'); break; }
    default:{ $_SESSION['CURRENT_PAGE'] = 9; include('page/404.php'); break; }
}
