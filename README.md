# Blog OCR
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
