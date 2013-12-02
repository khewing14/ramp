
# Production environment does not need SetEnv APPLICATION_ENV production
<VirtualHost *:80>
      ServerName smart.njala.edu.sl
      ServerAlias www.smart.njala.edu.sl
      DocumentRoot /var/www/ramp/public
      ErrorLog /var/log/ramp/error.log
      CustomLog /var/log/ramp/access.log combined
      <Directory "/var/www/ramp/public">
          Options MultiViews SymlinksIfOwnerMatch
          AllowOverride All
          Order allow,deny
          Allow from all
      </Directory>
 </VirtualHost>

