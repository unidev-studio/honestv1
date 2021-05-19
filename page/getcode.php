<?PHP
	if(isset($_GET['key'])) $GOOGLE_KEY = $_GET['key'];
	else $GOOGLE_KEY = 0;
	if($GOOGLE_KEY) {
		$ga = new GoogleAuthenticator;
		$GOOGLE_CODE = $ga->getCode($GOOGLE_KEY);
	}
	else $GOOGLE_CODE = 0;
	echo $GOOGLE_CODE;
?>