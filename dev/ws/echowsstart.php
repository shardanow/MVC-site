<?php
$baseDir = dirname(__FILE__);
$pidfile = $baseDir.'/pid_file.pid';

if( file_exists($pidfile) ) {	//�� ����� ������ ������� �������� �� ������������ � ������� ������, pid-���� ����, ������ �� ��������. 
	echo "{run:1}"; //1 ��� �������
} else {
	exec("php -q echows.php &");
	echo "{run:2}"; //2 ������ ����� �������
}
?>
