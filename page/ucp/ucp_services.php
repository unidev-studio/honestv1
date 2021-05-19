<div class="container">
		<div class="col-md-12 post">
			<h1>Личный кабинет</h1>
			<br><table width="100%" style="text-align: left; height: auto;" border="0">
			<tbody>
				<tr>
					<td width="20%">
					</td>
					<td width="60%">
						<h3>Ваш баланс <span id="balance">0</span> рублей. <a href="?page=balance">Пополнить!</a></h3><br>
						<div class="services_box">
							<!--
							<div class="service_item">
								<div class="service_name">Сменить NickName<br>Цена: 50 рублей</div>
								<input id="newnick" name="newnick" placeholder="RP NickName" type="text" maxlength="24" pattern="[A-Z_a-z]{3,24}" title="Не более 24 латинских символов." required>
								<button onclick="BuyService(0);">Купить</button>
							</div>
							-->
							<div class="service_item">
								<div class="service_name">Снять Warn<br>Цена: 200 рублей</div>
								<button onclick="BuyService(1);">Купить</button>
							</div>
						</div>
					</td>
					<?PHP UCP_MENU();?>
				</tr>
			  </tbody>
			</table>
		</div>
		<br>
		<br>
	</div>
	<script>
	function BuyService(service)
	{
		var balance = jQuery('#balance').html();
		var price = [50,200,250];
		if(price[service] > balance) swal('Ошибка!', 'У Вас недостаточно средств!', 'error');
		else
		{
			if(service == 0)
			{
				var newnick = jQuery('#newnick').val();
				jQuery.ajax({
				type:'GET',
				url:'/buyservice',
				dataType:'json',
				data:"service="+service+"&nickname="+newnick,
				success: function(data)
				{
					if(data.status == 0) swal('Ошибка!', data.text, 'error');
					else if(data.status == 1) swal('Готово!', data.text, 'success');
				}		
				});
			}
			else
			{
				jQuery.ajax({
				type:'GET',
				url:'/buyservice',
				dataType:'json',
				data:"service="+service,
				success: function(data)
				{
					if(data.status == 0) swal('Ошибка!', data.text, 'error');
					else if(data.status == 1) swal('Готово!', data.text, 'success');
				}		
				});
			}
		}
	}
	function UpdateBalance()  
	{
		var balance = jQuery('#balance').html();
		jQuery.ajax({
		type:'GET',
		url:'/auto_update',
		dataType:'json',
		data:"action=1",
		success: function(data)
		{
			if(balance != data.answer_1) $("#balance").html(data.answer_1);
		}		
		});	
	}
	jQuery('document').ready(function() 
	{
		UpdateBalance();
		setInterval('UpdateBalance()',1000);
	});	
	</script>