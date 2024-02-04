MANUAL DE INSTALAÇÃO:

-- Primeiramente configure seu ambiente com o php versão 7.2, o apache/2.4.52 e o Mysql versão 8.0 ou compatíveis.

--Em sequência, clone o respositório da branch main do git com (git clone -b main https://github.com/guilherme-zanella-talaska/app_vendas) no diretório raiz de instalação do apache.

--Com o projeto devidamente clonado, no diretório app_vendas/backend/www há o arquivo .sql para criar a estrutura do banco de dados. Pegue a query do arquivo e jogue no seu SGBD para criar as tabelas.

--Configure o banco de dados com o usuário root e senha vazia, mas caso deseje alterar, você poderá acessar a pasta bootstrap dentro de backend e alterar as variáveis globais para o db e senha que preferir;

--Com tudo isso feito, basta acessar o localhost/app_vendas, cadastrar um usuário e utilizar o sistema.
