#! /bin/bash
cp .env.example .env

#./sail down --rmi all -v || true

./sail build

./sail up -d

./sail composer install --ignore-platform-reqs

./sail artisan migrate --seed

./sail

./sail npm install

./sail npm run dev
# Added for fail safe
./sail down && ./sail up -d
