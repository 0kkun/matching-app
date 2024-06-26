up:
		docker-compose up -d
build:
		docker-compose build
create-project:
		docker-compose exec php composer create-project --prefer-dist "Laravel/laravel=6.*" 
install:
		docker-compose up -d --build
		docker-compose exec app composer install
		docker-compose exec app cp .env.example .env
		docker-compose exec app php artisan key:generate
		docker-compose exec app php artisan migrate:fresh --seed
reinstall:
		@make destroy
		@make install
stop:
		docker-compose stop
restart:
		docker-compose restart
down:
		docker-compose down
destroy:
		docker-compose down --rmi all --volumes
ps:
		docker-compose ps
work:
		docker-compose exec php bash
fresh:
		docker-compose exec php php artisan migrate:fresh
seed:
		docker-compose exec php php artisan db:seed
tinker:
		docker-compose exec php php artisan tinker
dump:
		docker-compose exec php php artisan dump-server
test:
		docker-compose exec php php ./vendor/bin/phpunit
cache:
		docker-compose exec php composer dump-autoload -o
		docker-compose exec php php artisan optimize:clear
		docker-compose exec php php artisan optimize
cache-clear:
		docker-compose exec php php artisan optimize:clear
cs:
		docker-compose exec php ./vendor/bin/phpcs
cbf:
		docker-compose exec php ./vendor/bin/phpcbf
db:
		docker-compose exec db bash
db-testing:
		docker-compose exec db-testing bash
mysql:
		docker-compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
mysql-testing:
		docker-compose exec db-testing bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
node:
		docker-compose exec node ash
npm:
		docker-compose exec node npm install
		docker-compose exec node npm run dev
yarn:
		docker-compose exec node yarn
		docker-compose exec node yarn run dev
logs:
		# アプリのログを見る
		docker-compose logs -f --tail="5" -t
google_api:
		# google-apiのパッケージをインストールする (youtube api v3)
		docker-compose exec php composer require google/apiclient:"^2.0"
goute:
		# スクレイピングツールをインストールする
		docker-compose exec php composer require weidner/goutte
redis:
		docker-compose exec redis redis-cli
