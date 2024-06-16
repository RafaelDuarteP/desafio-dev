# Projeto Desafio Dev

Projeto do Desafio Técnico da CIENTEC

## Descrição

Este projeto é uma aplicação web para cadastro de cidadãos, onde cada cidadão recebe automaticamente um Número de Identificação Social (NIS). A aplicação permite cadastrar cidadãos e buscar registros existentes pelo NIS.

### Cenário

O NIS (Número de Identificação Social) é um identificador único atribuído pela Caixa Econômica Federal aos cidadãos. Composto por 11 dígitos, é utilizado para realizar o pagamento de benefícios sociais, como chave de identificação nas Políticas Públicas, emissão de documentos, dentre outras utilidades.

### Desafio

Crie uma aplicação contendo um formulário para cadastrar cidadãos. O formulário deve conter um único campo para informar o nome do cidadão. Ao ser cadastrado, um número NIS deve ser gerado automaticamente, atribuído a esta pessoa e exibido na tela junto de uma mensagem de sucesso.

Deve ser possível também pesquisar os registros já existentes através do número NIS. Caso o NIS informado já esteja cadastrado, a aplicação deve exibir o nome do cidadão e seu número NIS. Caso não esteja, deve exibir: “Cidadão não encontrado”.

## Requisitos

Para executar o projeto, você precisará de:

- Docker v26.1.4
- Docker-Compose v2.27.1

## Instalação

1. Clone o repositório do projeto:

    ```bash
    git clone https://github.com/RafaelDuarteP/desafio-dev.git
    cd desafio-dev
    ```

2. Verifique se o Docker e o Docker-Compose estão instalados:

    ```bash
    docker --version
    docker-compose --version
    ```

## Uso

1. Execute o comando de inicialização:

    ```bash
    docker-compose up --build -d
    ```

2. Verifique se todos os serviços estão rodando:

    ```bash
    docker ps
    ```

3. Abra o navegador em `http://localhost:3333/`

## Descrição da Solução

O repositório contém uma solução que integra diversas tecnologias para criar um sistema web robusto e escalável. A solução é composta por uma API desenvolvida em PHP e um aplicativo web em HTML, ambos operando em ambientes contêinerizados com Docker juntamente com serviços de banco de dados MySQL e proxy Nginx orquestrados dentro de um docker-compose.

### Estrutura do Sistema

1. **Backend**:
   - **Tecnologia**: PHP
   - **Porta**: 8080
   - **Descrição**: A API em PHP é responsável pelo processamento de dados e comunicação com o banco de dados MySQL.
   - **Gateways**:
     - `GET /`: Verificação de estabilidade do servidor.
     - `GET /cidadaos`: Retorna uma lista de cidadãos.
     - `GET /cidadaos/{nis}`: Retorna o cidadão que possui o NIS informado.
     - `POST /cidadaos`: Cadastra um novo cidadão. O corpo da requisição deve conter `{"nome": "nome do cidadão"}`.

2. **Frontend**:
   - **Tecnologia**: HTML com servidor http-server
   - **Porta**: 5500
   - **Descrição**: O aplicativo web é servido através do http-server, um servidor HTTP simples para arquivos estáticos.

3. **Banco de Dados**:
   - **Tecnologia**: MySQL
   - **Descrição**: Armazena todos os dados necessários para o funcionamento do sistema.

4. **Integração e Proxy**:
   - **Servidor**: Nginx
   - **Porta**: 3333
   - **Descrição**: O Nginx atua como um proxy reverso, direcionando o tráfego para o backend e o frontend conforme necessário.

### Contêineres Docker

Estrutura dos contêineres dentro do docker-compose:

1. **desafio_dev_mysql**:
   - **Serviço**: db
   - **Descrição**: Contêiner Docker dedicado ao MySQL.

2. **desafio_dev_api**:
   - **Serviço**: api
   - **Descrição**: Contêiner Docker executando o servidor PHP na porta 8080.
   - **Dependências**: db

3. **desafio_dev_app**:
   - **Serviço**: app
   - **Descrição**: Contêiner Docker rodando o http-server na porta 5500.
   - **Dependências**: api

4. **desafio_dev_nginx**:
   - **Serviço**: nginx
   - **Descrição**: Contêiner Docker configurado como proxy reverso rodando na porta 3333.

### Estrutura de Diretórios

- `/backend`: Contém o código fonte da API em PHP e o arquivo Dockerfile para a criação da imagem para o contêiner.
- `/frontend`: Contém o código fonte do aplicativo web em HTML e o arquivo Dockerfile para a criação da imagem para o contêiner.
- `/docker`: Contém as configurações e scripts necessários para configurar os contêineres Docker, incluindo o MySQL e o servidor Nginx.

```plaintext
desafio-dev/
│
├── backend/
│   ├── Dockerfile
│   └── ...
├── frontend/
│   ├── Dockerfile
│   └── ...
├── docker/
│   ├── mysql/
│   │   └── init.sql
│   └── nginx/
│       └── nginx.conf
├── docker-compose.yml
└── README.md
```

### CI/CD

O projeto inclui pipelines de CI/CD para garantir a qualidade e integridade do código:

- **Testes Unitários**: Verificam individualmente as funções e métodos da aplicação.
- **Testes de Integração**: Validam a interação entre diferentes partes do sistema.

### Casos de Teste da API

Os testes automatizados são implementados utilizando PHPUnit. Abaixo estão descritos os casos de teste para a classe `Cidadao`:

1. **testCidadao**: Verifica se a instância de `Cidadao` é criada corretamente.
   ```php
   public function testCidadao() {
       $cidadao = new Cidadao();
       $this->assertInstanceOf(Cidadao::class, $cidadao);
   }
   ```

2. **testGetNome**: Testa se o método `getNome` retorna o nome corretamente após ser definido.
   ```php
   public function testGetNome() {
       $cidadao = new Cidadao();
       $cidadao->setNome('João');
       $this->assertEquals('João', $cidadao->getNome());
   }
   ```

3. **testGetNis**: Testa se o método `getNis` retorna o NIS corretamente após ser definido.
   ```php
   public function testGetNis() {
       $cidadao = new Cidadao();
       $cidadao->setNis('12345678901');
       $this->assertEquals('12345678901', $cidadao->getNis());
   }
   ```

4. **testToArray**: Verifica se o método `toArray` retorna um array com os dados corretos.
   ```php
   public function testToArray() {
       $cidadao = new Cidadao();
       $cidadao->setNome('João')->setNis('12345678901');
       $this->assertEquals(['nome' => 'João', 'nis' => '12345678901'], $cidadao->toArray());
   }
   ```

5. **testCreateNisValido**: Testa se o método `createNis` gera um NIS válido (11 dígitos numéricos).
   ```php
   public function testCreateNisValido() {
       $cidadao = new Cidadao();
       $nis = $cidadao->createNis();
       $this->assertEquals(11, strlen($nis));
       $this->assertMatchesRegularExpression('/[0-9]{11}/', $nis);
   }
   ```

6. **testCreateNisUnico**: Verifica se o método `createNis` gera NIS únicos em chamadas consecutivas.
   ```php
   public function testCreateNisUnico() {
       $cidadao = new Cidadao();
       $nis1 = $cidadao->createNis();
       $nis2 = $cidadao->createNis();
       $this->assertNotEquals($nis1, $nis2);
   }
   ```

### Testes de Integração

Os testes de integração são configurados utilizando GitHub Actions. Abaixo estão descritos os passos para testar a integração dos serviços:

```yaml
name: Teste de build com docker

on:
    push:
        branches:
            - main
    pull_request:
        branches:
            - main

jobs:
    build:
        runs-on: ubuntu-latest

        steps:
            - name: Checkout
              uses: actions/checkout@v3

            - name: Build services
              run: docker-compose build

            - name: Run services
              run: docker-compose up -d

            - name: Wait for MySQL to be ready
              run: |
                until docker exec desafio_dev_mysql mysqladmin ping -

h"127.0.0.1" --silent; do
                  echo "Waiting for MySQL to be ready..."
                  sleep 5
                done
            
            - name: Verify api
              run: curl -X GET 0.0.0.0:8080/ --fail --silent

            - name: Verify app
              run: curl -X GET 0.0.0.0:5500/ --fail --silent

            - name: Verify API connection
              run: |
                cat <<EOF > body.json
                {
                  "nome": "Maria Clara"
                }
                EOF
                curl -X POST -H "Content-Type:application/json" -d "@body.json" http://0.0.0.0:8080/cidadaos --fail

            - name: Verify api in NGINX
              run: curl -X GET 0.0.0.0:3333/api/ --fail --silent

            - name: Verify app in NGINX
              run: curl -X GET 0.0.0.0:3333/ --fail --silent
            
            - name: Down services
              if: always()
              run: docker-compose down
```

1. **Checkout**: Faz o checkout do código fonte do repositório.
2. **Build services**: Constrói as imagens Docker para os serviços definidos no `docker-compose`.
3. **Run services**: Inicia os serviços em contêineres no modo deamon.
4. **Wait for MySQL to be ready**: Aguarda até que o serviço MySQL esteja pronto para aceitar conexões.
5. **Verify api**: Verifica se a API está rodando corretamente na porta 8080.
6. **Verify app**: Verifica se o aplicativo web está rodando corretamente na porta 5500.
7. **Verify API connection**: Verifica se é possível cadastrar um novo cidadão via API.
8. **Verify api in NGINX**: Verifica se a API está acessível através do proxy NGINX.
9. **Verify app in NGINX**: Verifica se o aplicativo web está acessível através do proxy NGINX.
10. **Down services**: Derruba os serviços após a conclusão dos testes, independentemente do resultado.