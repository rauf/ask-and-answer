<!DOCTYPE html>
<html>
	<head>
	 	<title><?php echo $title ?> : Ask and Answer</title>
	    <link rel="stylesheet" type="text/css" href="<?php echo ANA_HOME; ?>/assets/css/main.css">
		<script src="<?php echo ANA_HOME; ?>/assets/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo ANA_HOME; ?>/assets/js/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="<?php echo ANA_HOME; ?>/assets/css/jquery-ui.css" />
		<script type='text/javascript' src="<?php echo ANA_HOME; ?>/assets/js/main.js"></script>
	 </head>

	 <body>
	 	<h2 class="center"><a href="<?php echo '/'; ?>">Ask and Answer Platform </h2></a>
	 	<div id="uid" class="hidden"><?php echo $this->session->userdata('uid');?></div>

	 	<hr>
	 	<div id="nav-bar">
	
	 		<?php if (is_null($this->session->userdata('first_name'))) : ?>
				<input type="submit" id="askQuestionButton" onclick="displayQuestionContainer()" value="Ask Question" />
	 			<div><a href="javascript:loginSignUpButtonClick('register')">Login/Sign Up</a></div>
	 			<?php else : ?>
					<div> Welcome <?php echo $this->session->userdata('first_name') ?> </div>
					<input type="submit" id="askQuestionButton" onclick="displayQuestionContainer()" value="Ask Question" />
					<div><a href="javascript:logoutButtonClick()">Logout</a></div>
				<?php endif; ?>
	 	</div>

	 	<br/>
	 	<br/>
	 	<br/>

	 	<div id="askQuestionContainer" class="display-right" style="display: none;"> 
			<label>Title</label>	
 			<input id="questionTitle" type="text"/><br/>

 			<label>Description</label>	
 			<textarea id="questionDescription" rows="4" cols="50" style="resize: none;"></textarea><br/>
 			<div id="questionStatusField"></div>
 			<input id="postQuestionButton" type="submit" value="Post Question" onclick="postQuestionButtonClick()" />
 		</div>
	 	
	 	<div id="form">  <div class="Reglayer-bg" style="display: none"></div>

	 	<div class="Reg-layer" id="registerFormSave" style="display: none; top: 200px; left: 288px;"></div>
		<div class="Reg-layer" id="loginFormSave" style="display: none; top: 47px; left: 288px;"></div>