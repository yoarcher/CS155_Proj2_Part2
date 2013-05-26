CS155 Project2 Part2
================

login.php:
1. Add htmlspecialchars($_POST['login_username'], ENT_QUOTES|ENT_SUBSTITUTE) in three places:

	(1) In function validate_registration(): Before a new account is inserted, we escape special characters (including single and double quotes) in username, and then save it in the database. 

	(2) In function validate_login(): Since we escape special characters when creating a new acount, every time when we try to validate username, we should use the same escaping method at first.

	(3) In function display_login(): It escapes the username value appearing in the input tag, and show exactly the same value of inputs rather than dynamically modifying the page. It helps defend Attack E - Password Theft. 

2. Add double quotes in <input name=login_name>'s value attribute. Without quotes delineating the attribute value, any space character allows the user to inject new attributes and values. It also helps defend Attack E.


index.php:

1. Add a hiddentoken field and validation in the 'post' form, in order to defend CSRF attacks (eg. Attack B).

2. Use htmlspecialchars() to escape the input profile text in order to avoid SQL injection. For example, if the user enters [ hey',Zoobars='1000'; ] in the profile textarea, for unsafe version, the profile of all users will be set to [ hey ] and zoobars ammount will be 1000. However, with this change, quotes will be encoded. As as result, the risk of SQL injection can be decreased.


user.php:

1. Use htmlspecialchars($_GET['user'], ENT_QUOTES|ENT_SUBSTITUTE) to escape input username. 

	Reason 1: We escape special characters when creating a new acount, so we should use the same escaping method.

	Reason 2: It avoids XXS reflected attack (eg. Attack A - Cookie Theft).

2. Move up the location of <span id="zoobars">. In this way, the input profile cannot contain anything to overwrite <span id="zoobars">'s class name. As a result, its class name will not be incorectly read in script. It helps avoid XSS stored attack (eg. Attack D - Profile Worm).

3. Remove the eval function in the script. It also helps defend Attack D.

4. Add parseInt() function when we need to extract the value of <span id="zoobars">'s class name. Thus, variable total will not be set as strange value except numbers.

5. Move the location of script code to the bottom of the body in order to executing codes after the webpage is loaded.


transfer.php:
1. Add a hiddentoken field and validation in the 'post' form, in order to defend CSRF attacks (eg. Attack B).

2. Use htmlspecialchars($_GET['user'], ENT_QUOTES|ENT_SUBSTITUTE) to escape input recipient name, for we escape special characters when creating every account.


common.php: 
Modified the frame busting codes.

Originally, the script only makes the window to jump one level higher, namely jump to the parent level. But such operation shows a vulnerbility in double framing. We changed it to always jumpt to the toppest window by setting the "top.location = self.location" after detecting that the current location is not at the top level. This fixes the vulnerbility of attack 2 and 3 of CSRF and clickjacking.

Now if we try to modify files in iframes to attack or put a layout above the current page, it would be detected and the page would jump to the top to terminate the process of the attack.
