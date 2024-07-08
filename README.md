# yii2
API usando o framework yii2

Após fazer git clone
Entre na pasta do projeto e rode os comandos:
#### # Passo Opcional:
Antes de rodar o passo 1 abaixo você pode criar uma pasta no seu host para manter os dados do banco de dados permanentes e não perdê-los ao reiniciar os containers
- Crie uma pasta dentro do projeto chamada persistencia e outras duas dentro dela chamadas data_base e uplods. 
- Logo após descomente as linhas 23 e 46 no docker-compose.yml para usar essa pasta do host.

Caso queira criar a pasta persistencia depois, basta rodar docker compose down e fazer as alterações descritas acima e em seguida os próximos passos novamente.

# Passo 1: 
Rode o comando:

`docker compose up -d`

# Passo 2: 
Listar as imagens. 
Será mostrado o "container id" das imagens encontre o id da imagem yii2-app01 e guarde esse valor

`docker ps`

# Passo 3: 
Baixar os pacotes para o projeto:

`docker exec <container_id_passo2> bash -c 'cd basic/ ; composer i'`

# Passo 4: 
Executar os migrations
Execute: 

`docker exec <container_id_passo2> php /var/www/html/basic/yii migrate --interactive=0`

# Passo 5:
Para criação de usuário rode o comando:

docker exec <container_id_passo2> php /var/www/html/basic/yii create-user/index <login_usuario> <senha_usuario> <Nome de usuário>

Ex.: `docker exec <container_id_passo2> php /var/www/html/basic/yii create-user/index admin 1234567 Administrador`


# Como usar:
Abra um cliente REST, como postman, e chame os endpoints abaixo:

URL: http://localhost:9999/auth/login 
Descrição: Geração de jwt para fins de autenticação
Method: POST
Header: Não precisa ser informado
variaveis:
- login
- senha

Response: 
> 	{
		token:'valor_token'
	}

URL: http://localhost:9999/cliente/create
Descrição: Criação de cliente
Method: POST
Header: Authorization Bearer valor_token_acima
variaveis:
- nome
- cpf
- sexo
- foto

Response: 
> 	{
		status: "success",
		data: {
				nome: "Fulano",
				sexo: "M",
				cpf: "9998888888",
				foto: "",
				id: 1
		}
	}

URL: http://localhost:9999/cliente/index
Descrição: Listagem de clientes
Method: GET
Header: Authorization Bearer valor_token_acima
variaveis: nenhuma variável é necessária

Response: 
> 	[
		{
			id: 1,
			nome: "Fulano",
			cpf: "55574445855",
			cep: null,
			logradouro: null,
			numero: null,
			cidade: null,
			estado: null,
			complemento: null,
			foto: "",
			sexo: "M"
   	 }
	]

URL: http://localhost:9999/produto/create
Descrição: Criação de produtos
Method: POST
Header: Authorization Bearer valor_token_acima
variaveis:
- nome
- preco
- fk_cliente (aqui deve ser informado o id do cliente)
- foto

Response: 
> 	{
    	status: "success",
    	data: {
        	nome: "Produto x",
        	preco: "11.89",
        	fk_cliente: "1",
        	foto: "",
        	id: 1
    	}
	}

URL: http://localhost:9999/produto/index
Descrição: Listagem de produtos com possibilidade de filtro por cpf ou nome do cliente
Method: GET
Header: Authorization Bearer valor_token_acima
variaveis:
- cpf
- nome_cliente

Response: 
> 	[
    	{
        	id: 1,
        	nome: "Produto x",
        	preco: 11.89,
        	fk_cliente: 1,
        	foto: ""
    	}
	]
