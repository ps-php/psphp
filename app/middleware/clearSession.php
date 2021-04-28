<?php

if(isset($_SESSION['flashdata'])) {
	unset($_SESSION['flashdata']);
}

if(isset($_SESSION['validation'])) {
	unset($_SESSION['validation']);
}
