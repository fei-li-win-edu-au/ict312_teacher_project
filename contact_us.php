
<?php
	include ("include/header_nav.php");
?>



<main>
    <h2>Contact Us</h2>
    <div id="contact_us_form">
        <form >
            <table>
                <tr>
                    <td colspan="2">
                      <i class="fa fa-envelope" aria-hidden="true" id="contact-icon"></i>
                      <h4 style="display: inline-block;">Contact us</h4>
                    </td>
                    <td valign="middle">
                      <i class="fa fa-phone-square" aria-hidden="true" class="contact-icons" id="call-icon">&nbsp;&nbsp;</i>
                      <h4 style="display: inline-block;">130030030</h4>
                    </td>
                </tr>
                <tr>
                    <td>Your Name<br><input type="text" name="name" id="name" required></td>
                    <td>Your Phone<br><input type="tel" name="phone" id="phone" required></td>
                    <td rowspan="3" valign="top">Message<br><textarea rows="8" cols="40" name="message" id="message" required></textarea></td>
                </tr>
                <tr>
                    <td>Your Email<br><input type="email" name="email" id="email" required></td>
                    <td>Your location<br><input type="text" name="location" id="location" required></td>
                </tr>
                <tr>
                    <td>Visit Date<br><input type="date" name="date" id="date" required></td>
                    <td>Visit Time<br><input type="time" name="time" id="time" required></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit">  <input type="reset"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <i class="fa fa-map" aria-hidden="true" id="map-icon">&nbsp;&nbsp;</i>
                        <h4 style="display: inline-block;">How to get to us</h4>
                        <p>Please refer to the following on how to get to our office.</p>
                        <div align="center">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.8646508376873!2d151.20405751498743!3d-33.86737888065675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae409a28ca7f%3A0xe6526c5aa1a7e548!2s10+Barrack+St%2C+Sydney+NSW+2000!5e0!3m2!1sen!2sau!4v1557922017696!5m2!1sen!2sau" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</main>

<?php
	include ("include/footer.php");
?>


