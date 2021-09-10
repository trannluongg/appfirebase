<div align="center">
  <img src="https://123job.vn/images/logo/logo349x137tim.png" width="400">
</div>

<div align="center">
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</div>

# Thực hành với Firebase
## 1. Cài đặt Project
```
composer install

cp .env.example .env

php artisan key:generate

php artisan cache:clear
php artisan config:cache

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=firebase_db
DB_USERNAME=root
DB_PASSWORD=password

php artisan migrate

composer require laravel/jetstream

php artisan jetstream:install livewire

php artisan migrate

npm i

npm run dev
```
## 2. Cài đặt Https
[Tham khảo](https://viblo.asia/p/tao-ssl-certificate-authority-cho-https-tren-local-1VgZvpQY5Aw).
### Tạo Certificate Authority
```
openssl genrsa -des3 -out rootCA.key 2048
openssl req -x509 -new -nodes -key rootCA.key -sha256 -days 1825 -out rootCA.pem
```
###Cài đặt Root Certificate cho các trình duyệt
**Google Chrome**

Đầu tiên, mở Google Chrome và truy cập vào đường dẫn sau: chrome://settings/certificates. Sau đó, bạn chọn tab Authorities và nhấp vào IMPORT rồi chọn file rootCA.pem mà chúng ta vừa tạo ban nãy. Sau khi chọn file đó, sẽ tích chọn hết các ô checkbox và bấm Ok
###Tạo HTTPS cho local site

```
openssl genrsa -out appfirebase.abc.key 2048
openssl req -new -key appfirebase.abc.key -out appfirebase.abc.csr
```

```
vi appfirebase.abc.ext
```
Và nhập nội dung bên dưới và save lại:
```
authorityKeyIdentifier=keyid,issuer
basicConstraints=CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = appfirebase.abc
```
Tiếp tục:
```
openssl x509 -req -in appfirebase.abc.csr -CA rootCA.pem -CAkey rootCA.key -CAcreateserial \
-out appfirebase.abc.crt -days 1825 -sha256 -extfile appfirebase.abc.ext
```

###Cài đặt HTTPS với NginX
```
sudo vi /etc/nginx/sites-available/appfirebase.abc
```
Và nhập nội dung bên dưới và save lại:

```
server {
 listen 80;
  listen [::]:80;

  server_name appfirebase.abc  www.appfirebase.abc;

    return 301 https://$server_name$request_uri;
}

server {
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    listen 443 ssl;
    listen [::]:443 ssl;

    ssl_certificate      /path/to/appfirebase.abc.crt;
    ssl_certificate_key  /path/to/appfirebase.abc.key;
    ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers         HIGH:!aNULL:!MD5;

    server_name appfirebase.abc www.appfirebase.abc;

    root /var/www/appfirebase/public;
   index index.php index.html index.htm index.nginx-debian.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}

```
Tiếp tục:
``` 
sudo ln -s /etc/nginx/site-available/appfirebase.abc /etc/nginx/site-enabled
```
Tiếp tục:
``` 
sudo service nginx restart
```

Tiếp tục:
``` 
sudo vi /etc/hosts
```
Tiếp tục:
``` 
127.0.0.1    appfirebase.abc
```
Vậy là xong, bây giờ bạn thử truy cập vào https://appfirebase.abc để xem kết quả nhá.