# Procedure

## Development

- Install LAMP packages 

- Download nextcloud server

- Place this app in **nextcloud/apps/**

- Start Server:

```bash
cd www/var/nextcloud
sudo php -S localhost:8080
```
- O App foi desenvolvido com o Node versao 16.16.0 e Instalado com ``` nvm ```, ```nvm``` e um gerenciador de versao do node e para instala-lo basta seguir o passo a passo <a href="https://github.com/nvm-sh/nvm">clicando aqui</a>

- Apos instalar o nvm, basta instalar a versao 16.16.0 do node com o seguinte comando:

```
nvm install 16.16.0 && nvm use 16.16.0
```

- Voce pode verificar se a versao esta correta rodando:

```
node --version 
```
- Para rodar o projeto, primeiro deve-se baixar as dependencias com o seguinte comando:

```sh
npm install
```
- Buildar o App com o seguinte comando:
```
npm run build
```
- go to http://localhost:8080/index.php/apps/procedure