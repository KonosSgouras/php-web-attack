<html><body>
<h1><?= "Puppies!" ?></h1>
<img src="https://i.ytimg.com/vi/DhpYAyVsFXQ/hqdefault.jpg"></img>
<form method="post" action="http://localhost:8001/modules/profile/profile.php?submit=yes"><br>
    <table width="99%">
    <tbody><tr>
       <th width="220" class="left">Όνομα</th><td><input class="FormData_InputText" type="text" size="40" name="prenom_form" value="Διαχειριστής"></td></tr>
    <tr>
       <th class="left">Επώνυμο</th><td><input class="FormData_InputText" type="text" size="40" name="nom_form" value="Πλατφόρμας"></td></tr><tr>
       <th class="left">Όνομα χρήστη (username)</th>
       <td><input class="FormData_InputText" type="text" size="40" name="username_form" value="drunkadmin"></td>

    </tr><tr><th class="left">email</th><td><input class="FormData_InputText" type="text" size="40" name="email_form" value="webmaster@localhost.gr"></td></tr><tr>
        <th class="left">Αριθμός μητρώου</th>
        <td><input class="FormData_InputText" type="text" size="40" name="am_form" value="01102022"></td>
    </tr><tr><th class="left">Αλλαγή εμφάνισης χαρτοφυλακίου</th><td>
		<input class="FormData_InputText" type="radio" name="persoStatus" value="no">Αναλυτικό&nbsp;
		<input class="FormData_InputText" type="radio" name="persoStatus" value="yes" checked="">Συνοπτικό
		</td>
    </tr>
    <tr>
      <th class="left">Γλώσσα</th>
      <td>
        
<select name="userLanguage" class="auth_input">
<option selected="" value="el">Ελληνικά</option>
<option value="en">English</option>
<option value="es">Español</option>
</select>

      </td>
    </tr>
	<tr>
      <th>&nbsp;</th>
      <td><input type="Submit" name="submit" value="Αλλαγή"></td>
    </tr>
    </tbody>
    </table>

</form>

</body></html>



