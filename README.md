# AWS Web Database Tutorial

Este projeto demonstra o deploy de uma **aplicação web PHP** na AWS EC2, conectada a um banco de dados MariaDB/MySQL no AWS RDS, incluindo:
- CRUD de Funcionários (`SamplePage.php`)
- CRUD de Produtos com 4 campos e 3 tipos de dados diferentes (`Produtos.php`)

## Estrutura do Projeto

| Arquivo            | Descrição                                                                              |
|--------------------|----------------------------------------------------------------------------------------|
| `SamplePage.php`   | Cadastro e listagem de funcionários (exemplo do tutorial AWS User Guide)               |
| `Produtos.php`     | Cadastro e listagem de produtos (tabela extra com campos: int, varchar, decimal, date) |
| `inc/dbinfo.inc`   | Arquivo com informações de conexão ao banco (NÃO VERSIONAR no GitHub)                  |

***

## Infraestrutura AWS utilizada

- **EC2 (Amazon Linux)**: Servidor Apache/PHP hospedando o site
- **RDS MariaDB/MySQL**: Banco de dados gerenciado na nuvem
- **Security Groups**: Configuração de acesso seguro (SSH restrito por IP, HTTP liberado na porta 80)

***

## Como testar/localmente ou replicar na AWS

### 1. Crie as instâncias

- EC2 (Amazon Linux, mínimo t2.micro)
- RDS MariaDB ou MySQL (dbname: sample, user: tutorial_user, senha definida por você)

### 2. Instale os pacotes necessários na EC2:

```bash
sudo dnf update -y
sudo dnf install -y httpd php php-mysqli mariadb105 git
sudo systemctl start httpd
sudo systemctl enable httpd
```

### 3. Clone este repositório na EC2 e mova os arquivos para `/var/www/html/`:

```bash
git clone https://github.com/davibasa/aws-web-db-tutorial.git
sudo cp aws-web-db-tutorial/SamplePage.php /var/www/html/
sudo cp aws-web-db-tutorial/Produtos.php /var/www/html/
sudo mkdir -p /var/www/inc
sudo nano /var/www/inc/dbinfo.inc   # Edite conforme abaixo
```

Conteúdo do `dbinfo.inc`, ajuste para seu ambiente:
```php
<?php
define('DB_SERVER', 'SEU_ENDPOINT_RDS');
define('DB_USERNAME', 'tutorial_user');
define('DB_PASSWORD', 'SUA_SENHA');
define('DB_DATABASE', 'sample');
?>
```

### 4. Crie as tabelas no banco (via cliente mysql):

```sql
-- Tabela Funcionários (já automatizada pelo código!)
-- Tabela Produtos:
CREATE TABLE PRODUTOS (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    preco DECIMAL(10,2),
    data_cadastro DATE
);
```

### 5. Acesse no navegador:

- Funcionários: `http://[DNS_PUBLICO_EC2]/SamplePage.php`
- Produtos: `http://[DNS_PUBLICO_EC2]/Produtos.php`

***

## Demonstração

Assista à demonstração dos serviços AWS, deploy e funcionamento da aplicação:

[**🔗 Link do vídeo de demonstração**](INSIRA_AQUI_A_URL_DO_SEU_VIDEO)

***

## Como funciona cada parte

- **SamplePage.php** = realiza criação automática da tabela EMPLOYEES e lista/add funcionários (usando formulário HTML+PHP)
- **Produtos.php** = CRUD de cadastro de produtos (int, string, decimal e date), lista e adiciona produtos
- **dbinfo.inc** = informações sensíveis de conexão (NUNCA suba este arquivo para o GitHub)
- **Security/Permissões** = diretórios com permissões para o usuário apache/ec2-user editar webroot
