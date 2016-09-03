#Wpanel CMS

##Um CMS para blogs, websites e pequenas aplicações desenvolvido com CodeIgniter 3.0.6.

Wpanel é um CMS (do inglês Content Manager System) ou Gerenciador de Conteúdo para blogs, sites e pequenas aplicações que eu desenvolvi para meus projetos em PHP.

A idéia inicial era de ter uma base sólida porém simples, sem milhões de códigos intermináveis e plugins de terçeiros que te deixa com calafrios na hora de dar manutenção. Por isso desenvolvi usando o Framework CodeIgniter por ser simples, e muito rápido, além de ser
muito popular, ter uma ótima documentação e uma boa comunidade.

O projeto já está estável e funcionando bem, com um painel de controle responsivo graças ao Bootstrap 3, e um site demonstrativo também responsivo e com uma otimização SEO básica.

É sem dúvida um bom ponto de partida para qualquer projeto. 

Se você gostar do Wpanel CMS e adotá-lo em algum projeto, envie-me um link com seus projetos desenvolvidos para adicionar ao Show-Case.

###Requisitos

- PHP >= 5.4.*
- MySql ou Sqlite
- Biblioteca Mcrypt ativada.

###Instalação

**Importante:**
Não use o repositório master em produção, ele é apenas para desenvolvimento. Para uso em produção use sempre o release mais atual.

#### Via Composer

1. Execute o comando:

	```
	composer create-project "elieldepaula/wpanelcms" Blog
	```
	Isto criará uma cópia do Wpanel CMS em um diretório 'Blog'
2. Crie uma base de dados MySql;
3. Execute a instalação inicial acessando pelo navegador: http://seusite/index.php/setup;
4. Informe os dados de conexão com a base de dados recém criada;
5. Na tela seguinte, crie o usuário administrador inicial;
6. Faça seu primeiro login no painel de controle;
7. Na Dashboard do painel de controle, clique na opção 'Visualizar Site', o site de exemplo já deve estar funcionando.
8. É recomendável que remova ou renomeie o modulo /app/modules/setup;

#### Download do projeto

1. Faça o download do último release em: <https://github.com/elieldepaula/wpanel/releases>;
2. Carregue todos os arquivos para o servidor onde ficará hospedado ou em seu servidor local;
3. Crie uma base de dados MySql;
4. Execute a instalação inicial acessando pelo navegador: http://seusite/index.php/setup;
5. Informe os dados de conexão com a base de dados recém criada;
6. Na tela seguinte, crie o usuário administrador inicial;
7. Faça seu primeiro login no painel de controle;
8. Na Dashboard do painel de controle, clique na opção 'Visualizar Site', o site de exemplo será aberto em uma nova aba ou janela dependendo do seu navegador.
9. É recomendável que remova ou renomeie o modulo /app/modules/setup;

# Contribuindo com o projeto

## Desenvolvendo

Contribua com o projeto me ajudando a desenvolver, pode começar clonando o repositório e enviando seus 'Pull-Requests'. Envie-me um email em dev[arroba]elieldepaula.com.br para trocarmos informações e manter um contato maior, mesmo que seja uma opinião ou uma dica já estará contribuindo.

##Doando

Doações financeiras são sempre bem vindas e ajudam a manter o foco no projeto evitando ter que dividir o tempo com muitos outros projetos, assim a evolução do projeto é bem mais rápida.

Se você deseja enviar uma doação, entre em contato comigo em dev[arroba]elieldepaula.com.br ou use o botão no site oficial <http://wpanelcms.com.br/#download>

#Licença

Este é um projeto pessoal em que trabalho a vários anos, estou disponibilizando sob a licença MIT, você pode usar da forma que achar melhor, mas sem nenhuma garantia. Se quiser contribuir para o projeto, entre em contato comigo pelo email dev[at]elieldepaula.com.br, clone o repositório e vamos fazer um CMS mais completo para quem usa CodeIgniter.

#The MIT License (MIT)

Copyright (c) 2014 Eliel de Paula
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.