<?php // Author: Stefano Peloso (http://stefano.io) - Released under CC BY-NC-SA 4.0 (http://creativecommons.org/licenses/by-nc-sa/4.0/)
if(substr($_SERVER["REMOTE_ADDR"],0,5)=="157.5")die;
if(trim(`ps -u storia -o rss,command | grep -v peruser | awk '{sum+=$1} END {printf("%.0f\\n", sum/1024)}' | awk '{print $0}'`)>450)die;
/* Understrike CMF(ramework) */
define('_','._');
define('DS',DIRECTORY_SEPARATOR);
define('__',DS.'..'.DS._); // @include dirname(__FILE__).__; nei _
define('_URL',urldecode(substr($_SERVER['REQUEST_URI'],1,($_l=strpos($_SERVER['REQUEST_URI'],"?"))!==false?$_l-1:999)));
if(_URL=="favicon.ico")die;
if(_URL=="rss.xml")die;
if(_URL=="feed/sdm.php")die;
if(_URL=="robots.txt")die;
if(_URL=="ricerca.php")die;
if(_URL=="posting.php")die;
if(_URL=="sitemap.php")die;
if(substr(_URL,0,16)=="apple-touch-icon")die;
//file_put_contents("richieste.txt",$_SERVER["REMOTE_ADDR"].": "._URL."\n",FILE_APPEND);
@session_start();
foreach(glob(dirname(__FILE__).DS."configurazione".DS."*")as $_r)require $_r;
function _autoload($_c){require_once _CLASSI.$_c._;}
spl_autoload_register("_autoload");
foreach(glob(_FUNZIONI."*")as $_r)require $_r;
$_COMPONENTI=isset($_POST["q"])?array(_RICERCA,"post"):(isset($_GET["q"])?array(_RICERCA,"get"):explode("/",preg_replace(array("#\.[a-z]+$#","#[^a-z0-9()_/-]+#","#^_#","#/_#","#(/)/+#","#^/#","#/$#"),'$1',strtolower(urldecode(_URL)))));
for($_i=count($_COMPONENTI);$_i;$_i--){
	if((boolean)($_p=implode(DS,array_slice($_COMPONENTI,0,$_i-1))))$_p.=DS;
	$_PAGINA=$_COMPONENTI[$_i-1];
	$_PARAMETRI=array_slice($_COMPONENTI,$_i);
	if(file_exists(($_PERCORSO=(_ADDETTO_AI_LAVORI&&file_exists(_CANTIERE.$_p.$_PAGINA.DS._PAGINA_DEFAULT._)?_CANTIERE:_PAGINE).$_p).$_PAGINA.DS._PAGINA_DEFAULT._)){
		@include $_PERCORSO.$_PAGINA.DS._;
		require $_PERCORSO.$_PAGINA.DS._PAGINA_DEFAULT._;
		die;
	}
	if(file_exists(($_PERCORSO=(_ADDETTO_AI_LAVORI&&file_exists(_CANTIERE.$_p.$_PAGINA._)?_CANTIERE:_PAGINE).$_p).$_PAGINA._)){
		@include $_PERCORSO._;
		require $_PERCORSO.$_PAGINA._;
		die;
	}
}
require _404;