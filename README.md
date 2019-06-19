# Blog OCR

[![SymfonyInsight](https://insight.symfony.com/projects/5605be44-b35d-49fe-b71c-70cb5f1c522b/small.svg)](https://insight.symfony.com/projects/5605be44-b35d-49fe-b71c-70cb5f1c522b)

# Configuration logicielle

* Un serveur avec Apache, PHP 7.1 et MySQL est indispensable
* Le module rewrite_engine sous Apache doit être activé
* L'extension xmlwriter de PHP doit être activée
* Composer doit être installé
* Git est nécessaire si vous souhaitez installer depuis un `git clone`

# Une fois le projet cloné

À la racine du projet, exécutez

* `composer install`
* `./vendor/bin/doctrine orm:schema-tool:update --force --dump-sql`
* `./vendor/bin/doctrine orm:generate:proxies`

# Création d'un compte Admin

* Créer un fichier php contenant ce code :

   ```
   <?php
   //Use this form to create login and crypted password using password_hash method.
   if (isset($_POST['login']) && isset($_POST['pwd']))
   {
   	$login = $_POST['login'];
   	$pwd_crypt = password_hash($_POST['pwd'],PASSWORD_BCRYPT);
   
   	echo "<p>Paste the result in User table :<br/><br/>" . $login . ":" . $pwd_crypt . "</p>";
   }
   else
   {
   ?>
   
   	<p>Create login and password to encrypt.</p>
   
   	<form method="post">
   		<p>
   			Login : <input type="text" name="login"><br/>
   			Password : <input type="text" name="pwd"><br/><br/>
   
   			<button type="submit" value="CRYPT">CRYPT</button>
   		</p>
   	</form>
   
   <?php
   }
   ?>
   ```
* Dans le terminal, connectez vous à MySQL 

    `mysql -u root -p`
    
* Copier le hash du mot de passe dans votre table User

    ```
    INSERT INTO User (username, passwordHash)
    VALUES ('votrePseudo', 'VotreHash');
    ```


# Configuration Apache

En admettant que le répertoire où vous ayez cloné le projet soit `/var/www/OCR_BLOG`, vous devrez ajouter un vhost avec la configuration suivante

```
<VirtualHost *:80>
    ServerAdmin h.boulangue@gmail.com
    DocumentRoot "/var/www/OCR_BLOG"
    ServerName blog.herveboulangue.fr
    ErrorLog "logs/blog_ocr-error_log"
    CustomLog "logs/blog_ocr-access_log" common
    <Directory "/var/www/OCR_BLOG">
      Options Indexes FollowSymLinks
      AllowOverride All
      #Require all granted
      RewriteEngine on
      RewriteRule  ^.*\.css$   -  [L,NC]
      RewriteRule  ^.*\.jpg$   -  [L,NC]
      RewriteRule  ^.*\.png$   -  [L,NC]
      RewriteRule  ^.*\.js$   -  [L,NC]
      RewriteRule  ^.*\.pdf$   -  [L,NC]
      RewriteRule ^.*$ System/Router.php
    </Directory>
</VirtualHost>
```
