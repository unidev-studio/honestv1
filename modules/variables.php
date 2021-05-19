<?php
$ci = rand(); # .css?v=

#- GetContent
$s_boost_cache = file('scripts/cache/s_boost.cache.php');
$s_toprich_cache = file('scripts/cache/s_toprich.cache.php');
$mt_all_num_cache = file('scripts/cache/mt_all_num.cache.php');
$adm_cfoll_info_cache = file('scripts/cache/adm_cfoll_info.cache.php');
$mt_all_cache = file_get_contents('scripts/cache/mt_all.cache.php');
$mt_peak_now_cache = file_get_contents('scripts/cache/mt_peak_now.cache.php');
$mt_peak_old_cache = file_get_contents('scripts/cache/mt_peak_old.cache.php');
$mt_fraction_list_cache = file_get_contents('scripts/cache/mt_fraction_list.cache.php');
$mt_job_list_cache = file_get_contents('scripts/cache/mt_job_list.cache.php');
$mt_top_list_cache = file_get_contents('scripts/cache/mt_top_list.cache.php');
$adm_toprich_list_cache = file_get_contents('scripts/cache/adm_toprich_list.cache.php');
$adm_cfoll_list_cache = file_get_contents('scripts/cache/adm_cfoll_list.cache.php');
$s_statemap_cache = file_get_contents('scripts/cache/s_statemap.cache.php');
$graph_toprich_all_cache = file_get_contents('scripts/cache/graph_toprich_all.cache.php');
$graph_toprich_vechiles_cache = file_get_contents('scripts/cache/graph_toprich_vechiles.cache.php');
$graph_toprich_businesses_cache = file_get_contents('scripts/cache/graph_toprich_businesses.cache.php');
$graph_toprich_farms_cache = file_get_contents('scripts/cache/graph_toprich_farms.cache.php');
$graph_toprich_banned_cache = file_get_contents('scripts/cache/graph_toprich_banned.cache.php');
$graph_toprich_mats_cache = file_get_contents('scripts/cache/graph_toprich_mats.cache.php');
$graph_toprich_drugs_cache = file_get_contents('scripts/cache/graph_toprich_drugs.cache.php');
$ss_clear = file('scripts/session_clear.txt.php');

#- Formules
$peak_percent = ($mt_peak_old_cache - $mt_peak_now_cache) / $mt_peak_old_cache * 100;
$peak_percent = round($peak_percent, 2); if($peak_percent < 100) $peak_percent = '-'.$peak_percent;
else{ $peak_percent = $peak_percent - 100; $peak_percent = '+'.$peak_percent; }

#- Variables
$SITE['s_boost_exp'] = $s_boost_cache[0];
$SITE['s_boost_donate'] = $s_boost_cache[1];
$SITE['s_boost_cash'] = $s_boost_cache[2];
$SITE['s_boost_time'] = date('d-m-Y', $s_boost_cache[3]);

$SITE['s_allcash'] = number_format($s_toprich_cache[0], 0, '', ',');
$SITE['s_acarcash'] = number_format($s_toprich_cache[1], 0, '', ',');
$SITE['s_abizcash'] = number_format($s_toprich_cache[2], 0, '', ',');
$SITE['s_afarmcash'] = number_format($s_toprich_cache[3], 0, '', ',');
$SITE['s_adban'] = number_format($s_toprich_cache[4], 0, '', ',');
$SITE['s_amats'] = number_format($s_toprich_cache[5], 0, '', ',');
$SITE['s_adrugs'] = number_format($s_toprich_cache[6], 0, '', ',');

$SITE['s_adm_cfoll_leaders'] = $adm_cfoll_info_cache[0];
$SITE['s_adm_cfoll_gos'] = substr(($adm_cfoll_info_cache[1] / 3600), 0, 5);
$SITE['s_adm_cfoll_gang'] = substr(($adm_cfoll_info_cache[2] / 3600), 0, 5);
$SITE['s_adm_cfoll_maf'] = substr(($adm_cfoll_info_cache[3] / 3600), 0, 5);

$SITE['s_mt_all_num'] = number_format($mt_all_num_cache[0], 0, '', ',');
$SITE['s_mt_all'] = $mt_all_cache;
$SITE['s_mt_peak_now'] = $mt_peak_now_cache;
$SITE['s_mt_peak_old'] = $mt_peak_old_cache;
$SITE['s_mt_peak_percent'] = $peak_percent;
$SITE['s_mt_fraction_list'] = $mt_fraction_list_cache;
$SITE['s_mt_job_list'] = $mt_job_list_cache;
$SITE['s_mt_top_list'] = $mt_top_list_cache;

$SITE['s_adm_toprich_list'] = $adm_toprich_list_cache;
$SITE['s_adm_cfoll_list'] = $adm_cfoll_list_cache;

$SITE['s_statemap_cache'] = $s_statemap_cache;

$SITE['s_tr_all'] = $graph_toprich_all_cache;
$SITE['s_tr_vechiles'] = $graph_toprich_vechiles_cache;
$SITE['s_tr_businesses'] = $graph_toprich_businesses_cache;
$SITE['s_tr_farms'] = $graph_toprich_farms_cache;
$SITE['s_tr_banned'] = $graph_toprich_banned_cache;
$SITE['s_tr_mats'] = $graph_toprich_mats_cache;
$SITE['s_tr_drugs'] = $graph_toprich_drugs_cache;