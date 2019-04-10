# simple-converter

How to install

clone this repo

run composer update 

rename .env.example to .env
and set your database configurations

run command php artisan migrate

register as a user
make post reques to /api/register provide name email password

then you will get your token 

to get currencies 
make get request to /api/currencies and provide token in url as a token parameter or in Authorization header as  Bearer <token>

to get a currency 
make get request to /api/currencies/<id> and provide token in url as a token parameter or in Authorization header as  Bearer <token>

to update currencies run php artisan get:currency command in the root directory
