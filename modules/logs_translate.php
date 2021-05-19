<?php
switch($r_translate) {
    case '+Перевел деньги в банке(/transfe': $r_translate = 'Получил деньги в банке от игрока'; break;
    case '-Перевел деньги в банке(/transfe': $r_translate = 'Перевел деньги в банке игроку'; break;
    case 'перевел в банке': $r_translate = 'Положил на банковский счёт'; break;
    case 'за промокод': $r_translate = 'За промокод [up 4lvl]'; break;
    case 'за промокод 2': $r_translate = 'За промокод [up 10lvl]'; break;
    case 'дом был продан': $r_translate = 'Слет дома в гос'; break;
    case 'chips buy': $r_translate = 'Купил фишки казино'; break;
    case 'chips sell': $r_translate = 'Продал фишки казино'; break;
    case 'ShowItog победил': $r_translate = 'Победил в кости'; break;
    case 'ExitBone': $r_translate = 'Вышел со столика казино'; break;
    case '/changehouse': $r_translate = 'Продал/Купил дом (/changehouse)'; break;
    case 'KEY_YES /changecar': $r_translate = 'Продал/Купил транспорт (/changecar)'; break;
    case '/gwage': $r_translate = 'Премия организации (/gwage)'; break;
    case 'QUEST_GUEST > автобус': $r_translate = 'Выполнил квест: Автобусник'; break;
    case 'QUEST_GUEST > дом': $r_translate = 'Выполнил квест: Покупка дома'; break;
    case 'pay biz48 item0 a1': $r_translate = 'Купил дом на колёсах'; break;
    case 'level up fHouse': $r_translate = 'Купил улучшение для семейного дома'; break;
    case 'KEY_YES accept gun': $r_translate = 'Купил оружие у бандита'; break;
    case '/givemoney': $r_translate = 'Получил деньги (/givemoney)'; break;
    case '/givepack': $r_translate = 'Получил пак сотр. (/givepack)'; break;
    default: $r_translate = $r_translate; break;
}
?>