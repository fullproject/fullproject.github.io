<?php

	/*

		pyprotect - by fullproject72@gmail.com
		Version 0.1alpha
		https://fullproject.github.io/pyprotecao

		This is an open source software
		Read LICENSE file before using it

	*/

	try{
		// Checks if file was chosen
		if(isset($_FILES['file']) && $_FILES['file']['name'] != ''){
			// Store error code for reference
			$err = 0;

			// Upload properties
			$_UP['folder'] = 'upload/'; // Destination folder
			$_UP['size'] = 1024 * 1024 * 5; // Maximum file size of 5 MB

			// Unexpected error check
			if($_FILES['file']['error'] != 0){header("Location: error");exit();}

			// Gets file extension
			$tmp = explode('.', $_FILES['file']['name']);
			$extension = strtolower(end($tmp));

			// Checks if extension is allowed
			if(trim($extension) != 'py'){
				// Invalid extension
				$err = 1;

			// Checks if file size is allowed
			}elseif($_UP['size'] <= $_FILES['file']['size']){
				// Invalid size
				$err = 2;
			}else{
				// Creates temporary filename
				$up_name = date('His') . '-' . $_FILES['file']['name'];

				// Does the upload
				if(move_uploaded_file($_FILES['file']['tmp_name'], $_UP['folder'] . $up_name)){

					// Reads the uploaded file
					$text = file_get_contents($_UP['folder'] . $up_name);

					// Checks if file is blank
					if(trim($text) == ''){
						// Blank file
						$err = 3;
					}else{
						// Encodes the text
						$encode = base64_encode($text);

						// Splits the encoded text into keywords
						$parts = str_split($encode, strlen($encode) / 4);

						// Creates result file
						$result = "# encoded by pyprotecao\r\n# by online site\r\n\r\nimport base64, codecs" . "\r\nmagic = '" . $parts[0] . "'\r\nlove = '" . str_rot13($parts[1]) . "'\r\ngod = '" . $parts[2] . "'\r\ndestiny = '" . str_rot13($parts[3]) . "'\r\n" . 'joy = \'\x72\x6f\x74\x31\x33\'' . "\r\n" . 'trust = eval(\'\x6d\x61\x67\x69\x63\') + eval(\'\x63\x6f\x64\x65\x63\x73\x2e\x64\x65\x63\x6f\x64\x65\x28\x6c\x6f\x76\x65\x2c\x20\x6a\x6f\x79\x29\') + eval(\'\x67\x6f\x64\') + eval(\'\x63\x6f\x64\x65\x63\x73\x2e\x64\x65\x63\x6f\x64\x65\x28\x64\x65\x73\x74\x69\x6e\x79\x2c\x20\x6a\x6f\x79\x29\')' . "\r\n" . 'eval(compile(base64.b64decode(eval(\'\x74\x72\x75\x73\x74\')),\'<string>\',\'exec\'))' . "";

						// Specifies result folder
						$_UP['result'] = 'result/';

						// Writes the new file and closes the stream
						$file = fopen($_UP['result'] . $up_name, 'w');
						fwrite($file,$result);
						fclose($file);
					}
				}else{
					// Upload error
					$err = 4;
				}
			}
		}else{
			// File not specified
			$err = 5;
		}
	}catch(Exception $e){
		// Unexpected error
		header("Location: error");
		exit();
	}
?>
<html>
	<head>
	    <!-- Tags -->
		<meta name="robots" content="noindex,nofollow">
		<meta charset="utf-8">
		<meta name="language" content="en">
		<meta http-equiv="content-language" content="en">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="author" content="fullproject72@gmail.com">
		<meta name="reply-to" content="fullproject72@gmail.com">
		<meta name="rating" content="general">
		<meta name="application-name" content="pyprotecao">
		<meta name="description" content="This is a simple online tool to obfuscate python codes and &quot;hide&quot; their sources.">
		<meta name="abstract" content="Online python code obfuscator.">
		<meta name="keywords" content="pyprotecao, python, obfuscate, obfuscator, crypt, encrypt, encode, pyobfuscate, tk, hide, source, secure, code, py, protecao">
		<meta property="og:site_name" content="pyprotecao">
		<meta property="og:type" content="website">
		<meta property="og:url" content="https://fullproject.github.io/pyprotecao">
		<meta property="og:title" content="pyprotecao">
		<meta property="og:image" content="https://fullproject.github.io/pyprotecao/ogicon.png">
		<meta property="og:image:type" content="image/png">
		<meta property="og:image:width" content="256">
		<meta property="og:image:height" content="256">
		<meta property="og:locale" content="pt_BR">
		<link rel="canonical" href="https://fullproject.github.io/pyprotecao">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>pyprotect</title>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" href="main.css">
	</head>
	<body>
		<table class="centeredContent" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<span class="title">pyprotect</span>
					<hr>
					<?php
						// Print results based on error code
						switch($err){
							case 0:
								echo '<span id="txt" style="color: #424242;">File protected successfully!<br><a href="' . $_UP['result'] . $up_name.'" target="_blank">DOWNLOAD</a><br><a href="index.php">PROTECT ANOTHER FILE</a><br><br><i>Files are deleted every hour.</i></span>';
								break;
							case 1:
								echo '<span id="txt" style="color: #424242;">Only .py files are allowed!<br><a href="index.php">TRY AGAIN</a></span>';
								break;
							case 2:
								echo '<span id="txt" style="color: #424242;">Maximum file size is 5 MB!<br><a href="index.php">TRY AGAIN</a></span>';
								break;
							case 3:
								echo '<span id="txt" style="color: #424242;">You chose a blank file!<br><a href="index.php">TRY AGAIN</a></span>';
								break;
							case 4:
								echo '<span id="txt" style="color: #424242;">There was a problem with your upload!<br><a href="index.php">TRY AGAIN</a></span>';
								break;
							case 5:
								echo '<span id="txt" style="color: #424242;">You haven\'t choose a file!<br><a href="index.php">TRY AGAIN</a></span>';
								break;
						}
					?>
					<hr>
					<span class="copy">by Gabriel Silva<br>
					<a href="http://fullproject72@gmail.com" target="_blank">[Website]</a>&nbsp;&nbsp;<a href="fullproject72@gmail.com" target="_blank">[Contact]</a>&nbsp;&nbsp;<a href="https://fullproject.github.io/pyprotecao" target="_blank">[Source]</a></span>
				</td>
			</tr>
		</table>
	</body>
</html>
