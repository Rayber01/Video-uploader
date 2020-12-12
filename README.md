## Project specifications 

This is a simple Cloud place to upload videos, very useful for screencasts, it uses [Bitly](https://bitly.com/) to shorten links, so you will need to register an account there and get a API key in order to be able to get shorter links for your uploaded media.

The project was built using Laravel to handle back-end, Vue to handle front-end stuff, reponsiveness was in charge of bootstrap.

## Installation

- file "run: cp .env.example .env"
- configure .env file, add your domain and API key provided by bitly.com
- configure database access in .env file
- run: composer install
- run: php artisan migrate
- run: php artisan db:seed
- run: npm install
- run: npm run dev
- run: php artisan storage:link
- php artisan run serve

**Note** by default login will be "test@example.com" and the password will be "test-video-uploader", you could change it by editting /database/seeders/UserSeeder.php and run php artisan db:seed again.
