  function start(){
    if(1 == jQuery('#checklogin').html()) return swal('Ошибка!', 'Выйдите из игры для прокрутки!', 'error');
    else if((49 > jQuery('#balance').html()) && (1 > jQuery('#freespins').html())) return swal('Ошибка!', 'У Вас недостаточно средств!', 'error');
    //
    else {
      setTimeout(SelMoney,100);
      setTimeout(UpdateInfo,1900);
    }
    //
	  var boxed = 4; // Начинаем считать кейсы
		var righ = 0; // Делаем анимацию увеличивая позицию в право
		var speed = Math.floor(Math.random() * (20 - 25 + 1)) + 25; // Скорость прокрутки рулетки
		var delbox = 128; // Ширина кейса для удаления его [164]
		var tim = setInterval(animated,10);
		$("button").css("opacity","0.5");
		$(".mainbutt").removeAttr("onclick");
        function animated(){
          //var imgs = Math.floor(Math.random() * (13 - 1 + 1)) + 1; // Случайная картинка
          var rtems = ['exp', 'exp', 'money', 'licenses', 'licenses', 'skills', 'skills', 'freespin', 'cashback', // Список предметов
          'exp', 'landstalker', 'dune', 'stretch', 'romero', 'washington', 'hotknife', 'euros', 'slamvan', 'camper', 'fcr900', 'quad', 'journey', //
          'exp', 'sk46', 'sk49', 'sk292', 'sk293', 'sk297', //
          'exp', 'bat', 'bat', 'boombox', 'cue', //
          'exp', 'vip', 'boost']; //
          var ritem = rtems[Math.floor(Math.random() * rtems.length)]; // Рандом из предметов
          var boostspin = jQuery('#boostspin').html(); // Подкрутка
          switch(ritem){
            case "exp":
              var percent = Math.random() * 101;
              if(percent < 98) var imgs = '1'; // 98%
              else var imgs = 0; break;
            case "money":
              var percent = Math.random() * 101;
              if(percent < 35) var imgs = '2'; // 35%
              else var imgs = 0; break;
            case "licenses":
              var percent = Math.random() * 101;
              if(percent < 88) var imgs = '3'; // 88%
              else var imgs = 0; break;
            case "skills":
              var percent = Math.random() * 101;
              if(percent < 88) var imgs = '4'; // 88%
              else var imgs = 0; break;
            case "freespin":
              var percent = Math.random() * 101;
              if(percent < 30) var imgs = '5'; // 30%
              else var imgs = 0; break;
            case "cashback":
              var percent = Math.random() * 101;
              if(percent < 25) var imgs = '6'; // 25%
              else var imgs = 0; break;
            // ТРАНСПОРТ //
            case "landstalker":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 17) var imgs = '7'; // 17%
                else var imgs = 0; break;
              }
              else {
                if(percent < 22) var imgs = '7'; // 22%
                else var imgs = 0; break;
              }
            case "dune":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 0.3) var imgs = '8'; // 0.3%
                else var imgs = 0; break;
              }
              else {
                if(percent < 0.007) var imgs = '8'; // 0.007%
                else var imgs = 0; break;
              }
            case "stretch":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 3) var imgs = '9'; // 3%
                else var imgs = 0; break;
              }
              else {
                if(percent < 1.2) var imgs = '9'; // 1.2%
                else var imgs = 0; break;
              }
            case "romero":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 3) var imgs = '10'; // 3%
                else var imgs = 0; break;
              }
              else{
                if(percent < 1.2) var imgs = '10'; // 1.2%
                else var imgs = 0; break;
              }
            case "washington":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 17) var imgs = '11'; // 17%
                else var imgs = 0; break;
              }
              else {
                if(percent < 23) var imgs = '11'; // 23%
                else var imgs = 0; break;
              }
            case "hotknife":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 4) var imgs = '12'; // 4%
                else var imgs = 0; break;
              }
              else {
                if(percent < 2) var imgs = '12'; // 2%
                else var imgs = 0; break;
              }
            case "euros":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 7) var imgs = '13'; // 7%
                else var imgs = 0; break;
              }
              else {
                if(percent < 4) var imgs = '13'; // 4%
                else var imgs = 0; break;
              }
            case "slamvan":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 5) var imgs = '14'; // 5%
                else var imgs = 0; break;
              }
              else {
                if(percent < 2) var imgs = '14'; // 2%
                else var imgs = 0; break;
              }
            case "camper":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 13) var imgs = '15'; // 13%
                else var imgs = 0; break;
              }
              else {
                if(percent < 19) var imgs = '15'; // 19%
                else var imgs = 0; break;
              }
            case "fcr900":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 6) var imgs = '16'; // 6%
                else var imgs = 0; break;
              }
              else {
                if(percent < 3) var imgs = '16'; // 3%
                else var imgs = 0; break;
              }
            case "quad":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 3) var imgs = '17'; // 3%
                else var imgs = 0; break;
              }
              else {
                if(percent < 1.2) var imgs = '17'; // 1.2%
                else var imgs = 0; break;
              }
            case "journey":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 3) var imgs = '18'; // 3%
                else var imgs = 0; break;
              }
              else {
                if(percent < 1.7) var imgs = '18'; // 1.7%
                else var imgs = 0; break;
              }
            // СКИНЫ //
            case "sk46":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 8) var imgs = '19'; // 8%
                else var imgs = 0; break;
              }
              else {
                if(percent < 4) var imgs = '19'; // 4%
                else var imgs = 0; break;
              }
            case "sk49":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 4) var imgs = '20'; // 4%
                else var imgs = 0; break;
              }
              else {
                if(percent < 1.2) var imgs = '20'; // 1.2%
                else var imgs = 0; break;
              }
            case "sk292":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 7) var imgs = '21'; // 7%
                else var imgs = 0; break;
              }
              else {
                if(percent < 11) var imgs = '21'; // 11%
                else var imgs = 0; break;
              }
            case "sk293":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 7) var imgs = '22'; // 7%
                else var imgs = 0; break;
              }
              else {
                if(percent < 11) var imgs = '22'; // 11%
                else var imgs = 0; break;
              }
            case "sk297":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 7) var imgs = '23'; // 7%
                else var imgs = 0; break;
              }
              else {
                if(percent < 11) var imgs = '23'; // 11%
                else var imgs = 0; break;
              }
            // АКСЕССУАРЫ //
            case "bat":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 50) var imgs = '24'; // 50%
                else var imgs = 0; break;
              }
              else {
                if(percent < 80) var imgs = '24'; // 80%
                else var imgs = 0; break;
              }
            case "boombox":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 14) var imgs = '25'; // 14%
                else var imgs = 0; break;
              }
              else {
                if(percent < 12) var imgs = '25'; // 12%
                else var imgs = 0; break;
              }
            case "cue":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 20) var imgs = '26'; // 20%
                else var imgs = 0; break;
              }
              else {
                if(percent < 15) var imgs = '26'; // 15%
                else var imgs = 0; break;
              }
            // ОСТАЛЬНОЕ //
            case "vip":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 22) var imgs = '27'; // 22%
                else var imgs = 0; break;
              }
              else {
                if(percent < 15) var imgs = '27'; // 15%
                else var imgs = 0; break;
              }
            case "boost":
              var percent = Math.random() * 101;
              if(2 == boostspin){
                if(percent < 24) var imgs = '28'; // 24%
                else var imgs = 0; break;
              }
              else {
                if(percent < 18) var imgs = '28'; // 18%
                else var imgs = 0; break;
              }
          }
          if (imgs == 0) animated();
          else {
	          var child4 = $(".tape:nth-child(4) img"); // Подсвечиваем товар который по середине
	          var firS = $(".tape:first-child");
	          var cons = righ - delbox; // Считаем на сколько блок зашел за границу
            if (righ >= delbox) { // Если блок за границей
              firS.remove(); // Удаляем его
              // И добавляем новый
              $("#boxes").append("<li class='tape'><img src='../resource/img/roulette_item/"+ritem+".png?v=7' name="+ritem+" alt="+imgs+" class='tape-img'></li>");
              righ = cons + speed;
              $(".tape").css("right",righ + "px");
              boxed++; // Считаем кол-во блоков
            } else {
              if(speed <= 2){
                speed -= 0.008;
              } else if (speed <= 6){
                speed -= 0.018;
              } else {
                speed -= 0.024;
              }
              righ += speed;
              $(".tape").css("right",righ + "px");
            }
 	        if (speed <= 0) {
            clearInterval(tim);
            setTimeout(swi,1600);
            $(".tape").animate({right: "64px"},1500);
            //$(".addimg img").attr("src"	,"../resource/img/roulette_item/roulette_item/"+child4.attr("name")+".png?v=7");
 	        }
          //$(".state").html("Бокс: "+boxed+"<br>Позиция: "+ righ+"<br>Скорость: "+speed+"<br> Отступ: "+cons); 			
        }
		}
  }
function UpdSpin(){
  var freespins = jQuery('#freespins').html();
  if(1 <= freespins) $("#textsp").html('бесплатно');
  else $("#textsp").html('за 49 руб.');
}
function UpdateInfo(){
	var balance = jQuery('#balance').html();
  var freespins = jQuery('#freespins').html();
  var checklogin = jQuery('#checklogin').html();
	jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=1",
	success: function(data){
		if(balance != data.answer_1) $("#balance").html(data.answer_1);
    //
    if(checklogin != data.answer_2) $("#checklogin").html(data.answer_2);
    //
    if(freespins != data.answer_3) $("#freespins").html(data.answer_3);
    setTimeout('UpdSpin()',650);
	}
	});
}
function UpdateMyItems(){
  jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=2",
	success: function(data){
		$("#item_box").html(data.answer_1);
	}
	});
}
function UpdateLiveItems(){
  jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=4",
	success: function(data){
		$("#live_item_box").html(data.answer_1);
	}
	});
}
function BoostSpin(){
  var boostspin = jQuery('#boostspin').html();
	jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=5",
	success: function(data){
    if(boostspin != data.answer_1) $("#boostspin").html(data.answer_1);
	}
	});
}
function SelMoney(){
	jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=7",
	success: function(data){
    if(data.text == 'error') swal('Ошибка', 'Произошла непревиденная ошибка. Пожалуйста, обратитесь к тех. администратору.', 'error');
	}
	});
}
function CheckError(){
  var checkerror = jQuery('#checkerror').html();
	jQuery.ajax({
	type:'POST',
	url:'/auto_update',
	dataType:'json',
	data:"action=8",
	success: function(data){
    if(checkerror != data.answer_1) $("#checkerror").html(data.answer_1);
	}
	});
}
function Use_Item(item_id){
	swal({
		title: 'Внимание!',
		text: "Вы действительно желаете использовать этот предмет?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Да',
    cancelButtonText: 'Отмена'
	}).then((result) => {
		if(result.value){
			jQuery.ajax({
				type:'POST',
				url:'/use_item',
				dataType:'json',
				data:"itemid="+item_id,
				success: function(data){
          if(data.text == 'WTERROR') swal('Ошибка', 'Не так быстро!', 'error');
          else if(data.text == 'ERROR_USER') swal('Ошибка', 'Пользователь не найден!', 'error');
					else if(data.text == 'ERROR') swal('Ошибка', 'Сначала выйдите с сервера!', 'error');
					else if(data.text == 'ERRORCAR') swal('Ошибка', 'У Вас уже имеется 1 автомобиль!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
					else if(data.text == 'ERRORCAR2') swal('Ошибка', 'У Вас уже имеется 2 автомобиля!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORCAR3') swal('Ошибка', 'У Вас уже имеется 3 автомобиля!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORLIC') swal('Ошибка', 'У Вас уже имеется комплект лицензий!', 'error');
          else if(data.text == 'ERRORSKILL') swal('Ошибка', 'У Вас уже полностью прокачано владение оружием!', 'error');
          else if(data.text == 'ERRORITEM') swal('Ошибка', 'У Вас уже заполнен инвентарь аксессуаров!', 'error');
          else if(data.text == 'ERRORBOOM') swal('Ошибка', 'У Вас уже имеется бумбокс в наличии!', 'error');
          else if(data.text == 'ERRORSKIN') swal('Ошибка', 'У Вас уже заполнен гардероб!<br>Продайте один из костюмов что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORVIP') swal('Ошибка', 'У Вас уже имеется VIP-Статус выше указанного!', 'error');
          else if(data.text == 'ERRORBOOST') swal('Ошибка', 'У Вас уже имеется Boost-Pack выше указанного!', 'error');
          else if(data.pay_user == 1){
            swal('Готово!', 'Вы успешно передали '+data.text+' '+data.name, 'success');
            setTimeout('UpdateMyItems()',100); setTimeout('UpdateInfo()',1900);
          }
					else {
            swal('Готово!', 'Вы успешно использовали '+data.text, 'success');
            setTimeout('UpdateMyItems()',100); setTimeout('UpdateInfo()',1900);
          }
				}
			});
		}
	});
}
function Pay_Item(item_id){ //inputValue
  swal({
    title: 'Внимание!',
    text: 'Введите никнейм человека, которому желаете передать этот предмет:',
    input: 'text',
    inputPlaceholder: 'Nick_Name',
    inputAttributes: { autocapitalize: 'off' },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Передать',
		cancelButtonText: 'Отмена'
  }).then((result) => {
		if(result.value){
			jQuery.ajax({
				type:'POST',
				url:'/use_item',
				dataType:'json',
        data:"itemid="+item_id+"&login="+result.value,
				success: function(data){
          if(data.text == 'WTERROR') swal('Ошибка', 'Не так быстро!', 'error');
          else if(data.text == 'ERROR_USER') swal('Ошибка', 'Пользователь не найден!', 'error');
					else if(data.text == 'ERROR') swal('Ошибка', 'Сначала выйдите с сервера!', 'error');
					else if(data.text == 'ERRORCAR') swal('Ошибка', 'У Вас уже имеется 1 автомобиль!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
					else if(data.text == 'ERRORCAR2') swal('Ошибка', 'У Вас уже имеется 2 автомобиля!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORCAR3') swal('Ошибка', 'У Вас уже имеется 3 автомобиля!<br>Продайте один из автомобилей что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORLIC') swal('Ошибка', 'У Вас уже имеется комплект лицензий!', 'error');
          else if(data.text == 'ERRORSKILL') swal('Ошибка', 'У Вас уже полностью прокачано владение оружием!', 'error');
          else if(data.text == 'ERRORITEM') swal('Ошибка', 'У Вас уже заполнен инвентарь аксессуаров!', 'error');
          else if(data.text == 'ERRORBOOM') swal('Ошибка', 'У Вас уже имеется бумбокс в наличии!', 'error');
          else if(data.text == 'ERRORSKIN') swal('Ошибка', 'У Вас уже заполнен гардероб!<br>Продайте один из костюмов что-бы использовать этот предмет.', 'error');
          else if(data.text == 'ERRORVIP') swal('Ошибка', 'У Вас уже имеется VIP-Статус выше указанного!', 'error');
          else if(data.text == 'ERRORBOOST') swal('Ошибка', 'У Вас уже имеется Boost-Pack выше указанного!', 'error');
          else if(data.pay_user == 1){
            swal('Готово!', 'Вы успешно передали '+data.text+' '+data.name, 'success');
            setTimeout('UpdateMyItems()',100); setTimeout('UpdateInfo()',1900);
          }
					else {
            swal('Готово!', 'Вы успешно использовали '+data.text, 'success');
            setTimeout('UpdateMyItems()',100); setTimeout('UpdateInfo()',1900);
          }
				}
			});
		}
	});
}
function Sell_Item(item_id){
	swal({
		title: 'Внимание!',
		text: 'Вы действительно желаете продать этот предмет?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Да',
    cancelButtonText: 'Отмена'
	}).then((result) => {
		if(result.value){
			jQuery.ajax({
				type:'POST',
				url:'/sell_item',
				dataType:'json',
				data:"itemid="+item_id,
				success: function(data){
          if(data.text == 'err1') swal('Ошибка', 'Отсутствуют предметы для продажи!', 'error');
          else if(data.text == 'err2') swal('Ошибка', 'Предмет не доступен для продажи!', 'error');
          else if(data.text == 'err3') swal('Ошибка', 'Имеется предмет не доступный для продажи!', 'error');
					else {
            swal('Готово!', 'Вы успешно продали '+data.text, 'success');
            setTimeout('UpdateMyItems()',100);
            setTimeout('UpdateInfo()',1900);
          }
				}
			});
		}
	});
}
function Sell_AllItem(item_id){
	swal({
		title: 'Внимание!',
		text: 'Вы действительно желаете продать все предметы?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Да',
		cancelButtonText: 'Отмена'
	}).then((result) => {
		if(result.value){
			jQuery.ajax({
				type:'POST',
				url:'/sell_item',
				dataType:'json',
				data:"itemid="+item_id,
				success: function(data){
          if(data.text == 'err1') swal('Ошибка', 'Отсутствуют предметы для продажи!', 'error');
          else if(data.text == 'err2') swal('Ошибка', 'Предмет не доступен для продажи!', 'error');
          else if(data.text == 'err3') swal('Ошибка', 'Имеется предмет не доступный для продажи!', 'error');
					else {
            swal('Готово!', 'Вы успешно продали '+data.text+'!', 'success');
            setTimeout('UpdateMyItems()',100);
            setTimeout('UpdateInfo()',1900);
          }
				}
			});
		}
	});
}
function GetPackage(item_id){
	jQuery.ajax({
	type:'POST',
	url:'/getitem',
	dataType:'json',
	data:"itemid="+item_id,
	success: function(data){
		//jQuery(".roulette_text").html('<h4>'+data.text+'</h4>');
    UpdateMyItems();
	}
	});
}
jQuery('document').ready(function(){
  CheckError();
  BoostSpin();
  UpdateLiveItems();
  setTimeout('UpdateInfo()',2000);
  setTimeout('UpdateMyItems()',4800);
  //setInterval('UpdateLiveItems()',30500);
  //setTimeout('CheckError(),BoostSpin()',86400000); // Сутки в мс
});
function swi(){
 	var nnu = $(".tape:nth-child(4) img").attr("alt");
  $(".mainbutt").attr("onclick","start()");
  $(".blscreen").toggle(400);
  $("button").css("opacity","1");
  switch(nnu){
    case "1": var itemname = "EXP"; break;
    case "2": var itemname = "Вирты"; break;
    case "3": var itemname = "Лицензии"; break;
    case "4": var itemname = "Скиллы"; break;
    case "5": var itemname = "Фриспин"; break;
    case "6": var itemname = "Кэшбек"; break;
    // ТРАНСПОРТ //
    case "7": var itemname = "Landstalker (400)"; break;
    case "8": var itemname = "Dune (573)"; break;
    case "9": var itemname = "Stretch (409)"; break;
    case "10": var itemname = "Romero (442)"; break;
    case "11": var itemname = "Washington (421)"; break;
    case "12": var itemname = "Hotknife (434)"; break;
    case "13": var itemname = "Euros (587)"; break;
    case "14": var itemname = "Slamvan (535)"; break;
    case "15": var itemname = "Camper (483)"; break;
    case "16": var itemname = "FCR-900 (521)"; break;
    case "17": var itemname = "Quad (471)"; break;
    case "18": var itemname = "Journey (508)"; break;
    // СКИНЫ //
    case "19": var itemname = "Скин №46"; break;
    case "20": var itemname = "Скин №49"; break;
    case "21": var itemname = "Скин №292"; break;
    case "22": var itemname = "Скин №293"; break;
    case "23": var itemname = "Скин №297"; break;
    // АКСЕССУАРЫ //
    case "24": var itemname = "Уникальная бита"; break;
    case "25": var itemname = "Уникальный бумбокс"; break;
    case "26": var itemname = "Уникальный кий"; break;
    // ОСТАЛЬНОЕ //
    case "27": var itemname = "VIP на 3 дня"; break;
    case "28": var itemname = "Boost-Pack"; break;
  }
  GetPackage(nnu);
  swal({
		title: 'Поздравляем!',
		text: "Вы получили "+itemname+" с рулетки!",
		icon: 'info',
		confirmButtonColor: '#3085d6',
		confirmButtonText: 'Забрать'
  });
}
function playSound(url){ // Воспроизводим звук
  var s = new Audio();
  s.src = url;
  s.play();
}
$(document).keypress(function (e) {
  if (e.which == 55 || e.which == 191) playSound("someSoundUrl.mp3");
})