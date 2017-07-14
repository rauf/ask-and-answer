<div onclick="closeRegLayer()" class="display-right">X</div>

<h2>Register</h2>

	<label for="first_name">First Name: </label>
    <input id="registerFirstNameField" type="text" name="first_name" required /><br />
	
	<label for="last_name">Last Name: </label>
    <input id="registerLastNameField" type="text" name="last_name" /><br />

    <label for="email">E-mail Id: </label>
    <input id="registerEmailField"  name="email" required /><br />

    <label for="password">Password: </label>
    <input id="registerPasswordField" type="password" name="password" required /> <br />

    <div id="registerStatus"></div>

    <a href="javascript:displayLoginForm()">Already Registered? Sign In!</a>
    <br/>

    <input id="registerSubmitButton" type="submit" name="submit" value="Register" />