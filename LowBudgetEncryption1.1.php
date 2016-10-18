<?php
/********************
Title: LowBudgetEncryption
Version: 1.1
Date: 09/26/2016
Last Edit: 10/01/2016
Author: Eduardo911
Last Edit By: Eduardo911
Description: This is a open source simple and free script to encrypt passwords.
function: PasswordEncryption
********************/
class passwordEncrypt{
	/*
	@param $encPassword will hold the final encrypted password.
	@param $chars will hold the characters to be use for the encryption.
	@param $upper, $lower, $numbers, & $symbols are the default settings for the type of characters to use for encryption.
	@param $upper, $lower, $numbers, & $symbols are public, therefor can be publicly change to your like.
	*/
	public $encPassword;
	public $upper = true;
	public $lower = true;
	public $numbers = true;
	public $symbols = false;
	public $passwordEncryptionLenght = 128;
	public $matrixLength = 5000;
	public $string;
	/*
	In my opinion every password encryption program should have hash generator for other uses.
	*/
	public function hashGenerator($length = 128){
		$characters = $this->setCharacters();
		$hashArray = array();
		for($i = 0; $i < $length; $i++){
			$hashArray[$i] = $characters[rand(0, count($characters)-1)];
		}
		return implode('', $hashArray);
	}
	/*
	setCharacters will set the characters to be use for encryption.
	return the characters to be use for encryption.
	*/
	public function setCharacters(){
		$chars = array('upper' => $this->upper, 'lower' => $this->lower, 'numbers' => $this->numbers, 'symbols' => $this->symbols);
		//The $char_table may be edited to your liking for more complex password pattern/encryption
		$char_table = array(
			'lower' => array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'),
			'upper' => array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'),
			'numbers' => array('0','1','2','3','4','5','6','7','8','9'),
			'symbols' => array("!","@","#","$","%","^","&","*","(",")","_","-","+","=")
		);
		$characters = array();
		foreach ($chars as $key => $value) {
			if($value){
				$characters = array_merge($characters, $char_table[$key]);
			}
		}
		return $characters;
	}
	/*
	Function encryptPassword takes one parameter, $pass.
	*/
	public function generateMatrix($chars, $start_range, $length){
		$matrix = array();
		$trigger = $this->string['count'];
		$char_count = count($chars);
		$y = $start_range[0];
		$range = 0;
		for($i = 0; $i < $length; $i++){
			if($trigger < 1){
				$trigger = $this->string['count'];
			}if($range > count($start_range)-1){
				$range = 0;
			}
			else{
				$trigger--;
			}
			$y = $y + $trigger + $start_range[$range] + $length;
			$matrix[$i] = $chars[$y%$char_count];
			$range++;
		}
		return $matrix;
	}
	public function encryptPassword($pass){
		//$string will be use to get multiple properties of the password as a string.
		$this->string = array(
			"string" => $pass,
			"count"  => strlen($pass)
		);
		//the function setCharacters() is executed to get all the initial characters to use for password encryption.
		$characters = $this->setCharacters();
		/* 
			In order to encrypt this password with a unique pattern I took the password and found the position
			on my character table. I took all positions that are found on my character table and use those numbers like patters
			I set the characters location as ranges in my $start_range variable.
		*/
		$start_range = array();
		for($x=0; $x<$this->string['count']; $x++){
			$start_range[$x] = array_search($this->string['string'][$x], $characters);
		}
		foreach ($start_range as $key => $value) {
			if($value == null){
				$start_range[$key] = $this->string['count'];
			}
		}
		/*
			Unique matrix is created depending on number of characters and the location of the characters
			I set for what i call my matrix to be 5000 characters to make the mattern more complex. you can set that to your liking i dont recommend going lower than 1000 characters.
		*/
		$matrix = $this->generateMatrix($characters, $start_range, $this->matrixLength);
		/*
			@param array will make sure the matrix is as complex as possible.
		*/
		$matrix_final = $this->generateMatrix($matrix, $start_range, $this->matrixLength);
		/*
			I have tested with 128 characters, havent test for less or more yet.
			this is where the magic happens and i use the same consept of creating a matrix to create the final encryption.
		*/
		$final_password = $this->generateMatrix($matrix_final, $start_range, $this->passwordEncryptionLenght);
		$this->encPassword = implode('',$final_password);
	}
}

$enc = new passwordEncrypt();
$enc->symbols = false;
$enc->passwordEncryptionLenght = 64;
$enc->encryptPassword("Password1");
echo $enc->encPassword;
//echo $enc->hashGenerator(64);

?>