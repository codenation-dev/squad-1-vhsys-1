![Central de Erros](https://www.imagemhost.com.br/images/2019/12/13/logo.png)

# Central de Monitoramento de Erros em Aplicações Web
## API REST FULL | Projeto Final | Squad-1 VHSYS

Em projetos modernos é cada vez mais comum o uso de arquiteturas baseadas em serviços ou microsserviços. Nestes ambientes complexos, erros podem surgir em diferentes camadas da aplicação (backend, frontend, mobile, desktop) e mesmo em serviços distintos. Desta forma, é muito importante que os desenvolvedores possam centralizar todos os registros de erros em um local, de onde podem monitorar e tomar decisões mais acertadas. Neste projeto vamos implementar um sistema para centralizar registros de erros de aplicações.

### Instalação Back-End

Siga os passos abaixo:
 - Baixe o repositório em seu ambiente utilizando: `git clone https://github.com/codenation-dev/squad-1-vhsys-1.git`
 - Renomear a pasta do back-end de `central-erros` para `central`
 - Dentro do diretório, execute o comando: `composer install`
 - Crie a base `Central` em seu banco de dados.
 - Execute o comando: `composer doctrine orm:schema-tool:create`
 
### Execução do Filtro de Erros

Para executar o filtro-capturador, siga os passos abaixo:
- Após baixar o diretório, conforme acima, dentro do diretório `filtroErros` execute o comando `php service.php`
- Informe o ambiente da aplicação que deseja monitorar, ex: `Dev`, `Homologação` ou `Produção`
- Informe o seu token de usuário.
- informe o caminho do log de erros do apache da aplicação.


### Especificações do Back-End `central-erros`:

- Endpoints para serem usados pelo frontend da aplicação.
- Endpoint que será usado para gravar os logs de erro em um banco de dados relacional.
- API segura, permitindo acesso apenas com um token de autenticação válido.

### Especificações do Front-End `central_erros_interface`:

- Acessivel adequadamente tanto por navegadores desktop quanto mobile.
- Consome a API do produto.

### Especificações do Filtro de Erros `filtroErros`:

- Captura exeções e erros gerados pelo log do apache.
- Envia as informações diretamente para o back-end da aplicação.
 
 ### Rotas da API
 
 #### Usuários:
 - `central/criar_usuario` método: `POST` | Cria um novo usuário (apenas um usuário autenticado pode criar um novo usuário, exite um login master para este procedimento por questões de segurança).
 - `central/usuario/id` método: `PUT` | Cria um novo usuário ou atualiza um usuário já existente.
 - `central/usuario/id` método: `PATCH` | Atualiza um usuário já existente.
 - `central/usuario/id` método: `DELETE` | Deleta um usuário específico.
 - `central/usuario/login` método: `POST` | Login de usuário cadastrado.
 - `central/usuario/esqueceu_senha` método: `POST` | Recuperação de senha de usuário.
 - `central/usuario/id` método: `GET` | Recupera informações de um usuário específico.
 - `central/usuario` método: `GET` | Recupera informações de todos os usuários.
 - `central/usuario/atualizar_token_usuario` método: `POST` | Atualiza token do usuário, caso esteja expirado.
 
 ---------------------------------------------------------------------------------------------------------------------------------------
 
 #### Erros:
 - `central/erro` método `POST` | Cria erro gerado na aplicação.
 - `central/erro/id` método `PUT` | Cira ou atualiza erro.
 - `central/erro/id` método `PATCH` | Atualiza erro existente.
 - `central/erro_arquivar` método `PUT` | Arquiva erro na base de dados da API.
 - `central/erro` método `POST`
 - `central/erro/id` método `DELETE` | Deleta erro específico da base de dados.
 - `central/erro/apagar` método `DELETE` | Deleta todos os erros (vinculádos ao usuário da requisição) da base de dados.
 
 ### Exemplos de requisições
 
 Para criar um usuário, deve-se seguir os exemplos abaixo:
 
 ##### HEADER da requisição:
 ```
 Content-type: application/json
 Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzU1NzQ2NTUsImlhdCI6MTU3NTIxNDY1NX0.X1g59-Q8jKwmjPnk7RZxjXrhKp5kp7Kq8VPdENPe8Wc
 ```
 ###### Conteúdo a ser enviado e token para autentiação.
 
 --------------------------------------------------------------------------------------------------------------------------------------
 ##### BODY da requisição:
 ```
 {
    "email":"teste@teste.com",
    "senha":"teste"
 }
 ```
 ###### E-mail e senha a serem cadastrados do novo usuário.
 
Todas as requisições devem conter o `HEADER` com as informações acima e o `BODY` com um `JSON` com os atributos necessários para cada tipo de requisição.
