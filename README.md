<h1 align="center">
  ⚡ Smart Home - LIT (Backend)
</h1>

## ❓ About 
Smart Home - LIT adalah project untuk menampilkan dashboard dan device management di sebuah rumah. Untuk pengembangan, _database_ yang digunakan menggunakan _dummy_ _database_ karena tidak tersambung secara langsung dengan hardware melalui protokol MQTT.

## 💾 Documentation
- [UI Wireframe](https://www.figma.com/file/vnzBpOdVkW5COuhIMBC7Kq/UI-Wireframe?node-id=2%3A3&t=rW2Nv1HVIVTVwMqn-0)
- Postman API Documentation

<hr/>

## ⚙ Setting Up Project
1. Clone the repo:
```````````
git clone https://github.com/mhmd-arif/LIT-smart-home-backend.git
```````````
2. Install required dependencies:
```````````
composer global require laravel/installer
composer install
```````````
3. Copy paste file .env | .env.example or make your own .env
4. Generate key:
```````````
php artisan key:generate
```````````
- Migrating to database:
``````````
php artisan migrate | php artisan migrate:fresh --seed
``````````
- Start serve:
``````````
php artisan serve
``````````

## 👨‍💻 Contributor
- [Saddan Syah Akbar](https://github.com/saddansyah)
- [Muhammad Arif Hidayat](https://github.com/mhmd-arif)
