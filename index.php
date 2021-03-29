<?php 
session_start();
ob_start();

include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

$title= GENCILANA;

if($action <> "get")
{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title><?php echo $title;?></title>

<meta http-equiv="content-type" content="text/html; charset=<?php echo CHARSET ?>">
<meta name="Description" content="Türkiye'nin En Genç İlan Sitesi">
<meta name="Keywords" content="resimli ilan,ilan,ev,araba,eşya,eğitim, araba ilanları,ev ilanları,kiralık,satılık,iphone,iphone4,ücretsiz iş ilanı,ücretsiz oto ilan, seri ilan,ücretsiz ilan,bedava ilan, ücretsiz emlak ilan,bilgisayar parçaları,tekne,klasik araba,çocuk oto koltuğu,oto yedek parça fiyatları,mp3 playerlar,gelinlik modelleri,bayan iç giyim, bayan çanta, bayan ayakkabı,SLR fotoğraf makinesi,cep telefonu fiyatları,motorsiklet fiyatları, motor,ikinci el araba fiyatları,2.el oto,online alışveriş, emlak fiyatları,Telefon, Müzik, Film, Kitap, Bebek  Çocuk, Ev Elektroniği, Beyaz Eşya  Mutfak, Hediyelik, Spor  Fitness, Çiçek, Sağlık  Güzellik, Saat, Oto Aksesuar, Hırdavat  Bahçe, Tariş, EvTekstil, PetShop, Takı  Mücevher, Mobilya, Dijital Fotoğraf  Kamera, Disney, Ayakkabı, Hobi Oyun, Outdoor Deniz, Taşınabilinir Bilgisayar, LCD Televizyon, MP3 Player, Tüm Markalar">

<link rel="shortcut icon" href="img/icon.ico"> 
<link rel="stylesheet" type="text/css" href="img/css/styles.css">

<script type="text/javascript" src="img/js/jquery.js"></script>
<script type="text/javascript" src="img/js/jquery-1.2.6.pack"></script>
<script type="text/javascript" src="img/js/loadderme.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
			
		function last_msg_funtion() 
		{ 
           var catId=$(".catId").attr("id");

           var ID=$(".message_box:last").attr("id");
			$('div#last_msg_loader').html('<img src="img/ajax_load.gif">');
			$.post("index.php?action=get&last_msg_id="+ID+"&cat="+catId,
			
			function(data){
				if (data != "") {
				$(".message_box:last").after(data);			
				}
				$('div#last_msg_loader').empty();
			});
			
		};  
		
		$(window).scroll(function(){
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){
			   last_msg_funtion();
			}
		}); 
		
	});
	</script>
	
</head>
<body>
<?php include"facebox.php";?>
<?php include("header.php"); ?>
<div class="container">

<div class="clear"></div>
	<div class="allads">
	
		<div class="AdsListBox">			
			<?php include('load_first.php');?>
			<div id="last_msg_loader"></div>
			<div id="<?php echo $_GET['cat']?>" class="catId"></div>
		</div>

	</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17289014-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php
}
else
{
include('load_second.php');		
}
?>
<?php ob_end_flush(); ?>