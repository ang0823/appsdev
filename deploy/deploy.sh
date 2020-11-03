#!/bin/bash
cd ..
BUILD_VERSION=$(cat build_number.txt)
BUILD_VERSION=$((BUILD_VERSION + 1))
rm build_number.txt
echo "$BUILD_VERSION" > build_number.txt

FILENAME="deploy/build_${BUILD_VERSION}_code.tar.gz"

ENV_DEV=$(cat .env)
ENV_PROD=$(cat .env.production)
rm .env
echo "$ENV_PROD" > .env
tar czf $FILENAME app/ bootstrap/ config/ database/ public/ resources/ routes/ storage/ .env artisan composer.json composer.lock server.php webpack.mix.js package.json package-lock.json
rm .env
echo "$ENV_DEV" > .env
scp $FILENAME angello93@192.168.1.73:/webs/

ssh angello93@192.168.1.73 << 'ENDSSH'
cd /webs/
rm -R desap
mkdir desap
tar xf *_code.tar.gz -C desap
rm *_code.tar.gz
cd desap
composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader
composer dump-autoload
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 777 storage
chmod -R 777 bootstrap/cache
ENDSSH