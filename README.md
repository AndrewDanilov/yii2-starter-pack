Yii2 Starter Pack
====
Starter pack for creating new projects

Install
----
composer create-project --prefer-dist andrewdanilov/yii2-starter-pack my-project "~1.0.0"

## Preparing application

After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these steps once for all.

1. Open a console terminal, execute the `init` command and select `dev` as environment.

    ```
    /path/to/php-bin/php /path/to/yii-application/init
    ```
    
    If you automate it with a script you can execute `init` in non-interactive mode.
    
    ```
    /path/to/php-bin/php /path/to/yii-application/init --env=Development --overwrite=All
    ```

2. Create a new database and adjust the `components['db']` configuration in `/path/to/yii-application/common/config/main-local.php` accordingly.

3. Open a console terminal, apply migrations with commands

    `/path/to/php-bin/php /path/to/yii-application/yii migrate`
    `/path/to/php-bin/php /path/to/yii-application/yii migrate --migrationPath=@andrewdanilov/adminpanel/migrations`

4. Set document roots of your web server:

    - for frontend `/path/to/yii-application/frontend/web/` and using the URL `http://frontend.test/`
    - for backend `/path/to/yii-application/backend/web/` and using the URL `http://backend.test/`

    For Apache there is already seted up `.htaccess` files in app root and in `frontend/web` and `backend/web`
    
    For Nginx, you can use following config:
    
    ```nginx
    # server configuration
    server {
        listen 80;
        server_name example.com;
    
        set $base_root /path/to/project/root;
        root $base_root;
    
        #error_log /var/log/nginx/advanced.local.error.log warn;
        #access_log /var/log/nginx/advanced.local.access.log main;
        charset UTF-8;
        index index.php index.html;
    
        # remove trailing slash
        location ~ .+/$ {
            rewrite ^/(.+)/$ /$1 permanent;
        }
    
        location / {
            root $base_root/frontend/web;
            try_files $uri $uri/ /frontend/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            location ~ ^/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
                log_not_found off;
                access_log off;
                try_files $uri =404;
            }
    
            location ~ ^/assets/.+\.php(/|$) {
                deny all;
            }
        }
    
        location /admin {
            alias $base_root/backend/web/;
    
            # prevent the directory redirect to the URL with a trailing slash
            location = /admin {
                try_files $uri /backend/web/index.php$is_args$args;
            }
    
            try_files $uri $uri/ /backend/web/index.php$is_args$args;
    
            # omit static files logging, and if they don't exist, avoid processing by Yii (uncomment if necessary)
            location ~ ^/admin/.+\.(css|js|ico|png|jpe?g|gif|svg|ttf|mp4|mov|swf|pdf|zip|rar)$ {
                log_not_found off;
                access_log off;
                try_files $uri =404;
            }
    
            location ~ ^/admin/assets/.+\.php(/|$) {
                deny all;
            }
        }
    
        location ~ ^/.+\.php(/|$) {
            rewrite (?!^/((frontend|backend)/web|admin))^ /frontend/web$uri break;
            rewrite (?!^/backend/web)^/admin(/.+)$ /backend/web$1 break;
    
            #fastcgi_pass 127.0.0.1:9000; # proxy requests to a TCP socket
            fastcgi_pass unix:/run/php/php7.4-fpm.sock; # proxy requests to a UNIX domain socket (check your www.conf file)
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            include /etc/nginx/fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            try_files $fastcgi_script_name =404;
        }
    
        location ~ /\. {
            deny all;
        }
    }
    ```