docker stop hortas_mysql
docker stop hortas_phpmyadmin

docker rm hortas_mysql
docker rm hortas_phpmyadmin

docker network create hortas_network

docker run -d --name hortas_mysql --network hortas_network -e MYSQL_ROOT_PASSWORD=root_password -e MYSQL_DATABASE=hortas_dev_db -p 3306:3306 mysql:8.0

docker run -d --name hortas_phpmyadmin --network hortas_network -e PMA_HOST=hortas_mysql -e PMA_PORT=3306 -e MYSQL_ROOT_PASSWORD=root_password -p 8080:80 phpmyadmin/phpmyadmin


docker run -d --name hortas_phpmyadmin --network hortas_network `
  -e PMA_HOST=hortas_mysql `
  -e PMA_PORT=3306 `
  -e PMA_USER=root `
  -e PMA_PASSWORD=root_password `
  -p 8080:80 phpmyadmin/phpmyadmin




meu venv já esta assim # Environment APP_ENV=development APP_DEBUG=true # Database DB_HOST=hortas_mysql DB_NAME=hortas_dev_db DB_USER=hortas_user DB_PASS=hortas_password DB_CHARSET=utf8mb4 # JWT JWT_SECRET=hortas_dev # API API_VERSION=v1