# yii2
API usando o framework yii2

Após fazer git clone
Entre na pasta do projeto e rode o comando
Passo Opcional
Antes de rodar o passo 1 abaixo você pode criar uma pasta no seu host para manter os dados
do banco de dados permanentes e não perdê-los ao reiniciar os containers
Crie uma pasta dentro do projeto chamada persistencia e outras duas dentro dela chamadas
data_base e uplods. 
Logo após descomente as linhas 23 e 46 no docker-compose.yml para usar essa pasta do host.

Passo 1: Rode o comando
docker compose up -d

Passo 2: 
List as imagens:
docker ps

Passo 3: 
No passo 2 será mostrado o "container id" das imagens encontre o id da imagem yii2-app01
docker exec <id_imagem_acima> php /var/www/html/basic/yii migrate --interactive=0

Passo 4:
Para criação de usuário rode o comando:
docker exec <id_image_acima> php yii create-user/index <login> <senha> <Nome de usuário>
Ex.: docker exec <id_image_acima> php yii create-user/index admin minha_senha Administrador
