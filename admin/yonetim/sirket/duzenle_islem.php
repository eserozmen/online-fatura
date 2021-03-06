<?php

     require '../_session_kontrol_3.php';
     require '../../my_class/sirket_detay.php';

    function geri_yonlendir($mesaj,$pk_sirket){
		$url = 'duzenle.php?pk='.$pk_sirket .'&msj='.$mesaj;
		echo "<script>
                         window.location = '{$url}';
	              </script>";
               exit();
	}
	
   $pk_sirket = $_GET['pk'];
   if (!$pk_sirket) {
		$mesaj = 'Şirket bilgileri eksik geldi..';
		geri_yonlendir($mesaj, $pk_sirket);
	}
   
    $sirket_isim = $_POST['sirket_isim'];
    $vergi_dairesi = $_POST['vergi_dairesi'];
    $vergi_no = $_POST['vergi_no'];
    $eposta = $_POST['eposta'];
    $web = $_POST['web'];
    $aciklama = $_POST['aciklama'];
    
    if (!$sirket_isim || !$vergi_dairesi || !$vergi_no ) 
         geri_yonlendir('Bilgileri eksik girdiniz...',$pk_sirket);
    
   $db = new sirket_detay();
    $sonuc = $db->sirket_getir_by_isim($sirket_isim);
        
    if ($sonuc && $sonuc['pk'] != $pk_sirket)         
        geri_yonlendir('Bu şirket ismi kullnılmakta.. Başka bir isim giriniz..', $pk_sirket);
    
    $sonuc = $db->guncelle($pk_sirket, strtoupper($sirket_isim),$vergi_dairesi,$vergi_no,$web,$eposta,$aciklama);
    if ($sonuc > 0) 
        $mesaj = 'Şirket başarılı bir şekilde güncellendi..';
    
    else 
        $mesaj='Şirket güncellenemedi...';
    
    geri_yonlendir($mesaj, $pk_sirket);
   

?>