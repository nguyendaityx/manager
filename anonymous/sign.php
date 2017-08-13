<? session_start();
if(!defined('CHIP_ROOT')) die ('Hello pro!');
echo '<div id="sign">';
switch($_GET['act']):
case 'up':
	echo '
		<div id="regform">
		<h1>Đăng ký tài khoản:</h1>
			<form action="javascript:return false;" method="post">
			<div><label>Nick name:</label><input type="text" id="username"/></div>
			<div><label>Mật khẩu:</label><input type="password" id="pass"/></div>
			<div><label>Nhập lại mật khẩu:</label><input type="password" id="repass"/></div>
			<div>
				<input type="button" value="Đăng ký" onclick="reg_check();"/>
				<input type="reset" value="Reset" />
			</div>
			</form>
		</div>    
	';
	if($_POST){
		extract($_POST);
		if(trim($user) && trim($pass)){
			$data = file('data/user.txt');
			foreach($data as $value){
				$x = explode('*|*',$value);
				if($user == $x[1]){
					$err[] = 'Tên <strong>'.$user.'</strong> TÀI KHOẢN ĐÃ SỬ DỤNG';
					break;
				}
			}
			if($err)
				echo implode('<br>',$err);
			else{	
				$content = '*|*'.$user.'*|*'.md5($pass).'*|*';
				$fp = fopen('data/user.txt','a');
				fwrite($fp,$content."\n");
				fclose($fp);
				echo 'ĐĂNG NHẬP THÀNH CÔNG <br>
				<strong>User:</strong> '.$user.'<br>
				<strong>Pass:</strong> '.$pass.'<br>';
			}
		}
	}
break;
case 'in':
	echo '
		<div id="regform">
		<h1>Đăng nhập:</h1>
			<form action="javascript:return false;" method="post">
			<div><label>Nick name:</label><input type="text" id="username"/></div>
			<div><label>Mật khẩu:</label><input type="password" id="pass"/></div>
			<div>
				<input type="button" value="Đăng nhập" onclick="log_check();"/>
				<input type="reset" value="Reset" />
			</div>
			</form>
		</div>    
	';
	if($_POST){
		extract($_POST);
		if(trim($user) && trim($pass)){
			$data = file('data/user.txt');
			$login = false;
			foreach($data as $value){
				$x = explode('*|*',$value);
				if(trim($user) == $x[1] && md5($pass) == $x[2]){
					$login = true;
					break;
				}	
			}
			if($login){
				$_SESSION['user_login'] = trim($user);
				echo 'ĐÃ ĐĂNG NHẬP<br>
				<a href="./"><b>NHAN VAO DAY DE CHAT</b></a>';
			}
			else
				echo 'SAI THÔNG TIN';
		}
	}
break;
endswitch;?>
