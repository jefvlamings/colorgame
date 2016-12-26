
<?php

Class Random{

	public $letters = array('a','b','c','d','e','f');
	public $numbers = array(0,1,2,3,4,5,6,7,8,9);

	public function randomLetter(){
		$this->letters;
		return $this->letters[array_rand($this->letters)];
	}

	// generate a random digit
	public function randomDigit(){
		$this->numbers;
		return array_rand($this->numbers);
	}

	// generate random 0 or 1
	public function randomBinary(){
		return mt_rand(0,1);
	}

}

Class Color extends Random{
	// validate hex number and convert it into a workable number
	// turn three character hex color in six character value
	// remove number sign from value
	public function validateHex($hex){
		if($hex[0] == "#"){
			$hex = substr($hex, 1);
		}

		if(strlen($hex) == 6){
			return $hex;			
		}
		else if(strlen($hex) == 3){
			$digits = str_split($hex);

			return 
				$digits[0] . $digits[0] . 
				$digits[1] . $digits[1] . 
				$digits[2] . $digits[2];

		}
		else{
			throw new Exception('Value is not a hexidecimal', 1);
		}
		
	}

	// split a hex color into its primary colors
	public function splitToPrimary($hex){

		$digits = str_split($hex);

		$primary = array(
				'r' => $digits[0] . $digits[1],
				'g' => $digits[2] . $digits[3],
				'b' => $digits[4] . $digits[5]
			);
		return $primary;
	}

	// convert hex values to RGB values
	public function hexToRGB($hex){

		$hex = $this->validateHex($hex);
		$primaries = $this->splitToPrimary($hex);

		$r = hexdec($primaries['r']);
		$g = hexdec($primaries['g']);
		$b = hexdec($primaries['b']);

		return array($r,$g,$b);

	}
	// print RGB values
	public function printRGB(array $rgb){
		$output = 'rgb(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ')';
		return $output;
	}

	// generate a random color (hexidecimal)
	public function randomColor(){
		$randomColor = NULL;
		for($i=0;$i<6;$i++){
			if($this->randomBinary() == 1){
				$randomColor .= $this->randomLetter();
			}
			else{
				$randomColor .= $this->randomDigit();
			}
		}

		return $randomColor;
	}

}

$color = new Color();
?>

<html>
<head>
	<title>Color Game!</title>
	<link rel="stylesheet" href="style.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script>
	 $(document).ready(function() {

		$('a').mousedown(function(){
			console.log("hello");
			$(this).attr("style","background-color: none");
		});
	});
	</script>
</head>
<body>
	<h1>Click the colored squares to reveal the image!</h1>
	<div id="image">
		<?php
			for($i=0;$i<1200;$i++){
				$randomColor = $color->randomColor();
				$rgb = $color->hexToRGB($randomColor);
				$rgbOutput = $color->printRGB($rgb);

				echo (
					'<a '
					.'class="pixel"'
					.'style="background-color:#' . $color->randomColor(). '"'
					.'title="#' . $randomColor . ' ' . $rgbOutput .'">&nbsp;</a>');
			}
		?>
	</div>
</body>
</html>
