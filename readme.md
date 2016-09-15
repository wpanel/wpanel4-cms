#Wpanel CMS

##Um CMS para blogs, websites e pequenas aplicações desenvolvido com CodeIgniter 3.x.

Wpanel CMS é um Gerenciador de Conteúdo para blogs, sites e pequenas aplicações que eu desenvolvi para meus projetos em PHP.

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

1. Faça o download do Wpanel CMS em .zip/.tar.gz, ou você pode clonar o repositório ou executar o comando abaixo caso você use o composer:

	```
	composer create-project "elieldepaula/wpanelcms" Blog
	```
	Isto criará uma cópia do Wpanel CMS em um diretório 'Blog'
2. Certifique-se de dar permissão de escrita nas pastas: app/sessions, app/cache, app/db e public/captcha;
3. Altere o arquivo app/config/config.php de acordo com seu ambiente e projeto;
4. Altere o arquivo app/config/database.php de acordo com o banco de dados que deseja usar;
	Caso deseje usar MySql, você precisará configurar uma nova base de dados no seu servidor.
5. Acesse seu site pelo navegador, no primeiro acesso você será direcionado para a criação de um usuário administrador;
6. Faça seu login no painel de controle, clique na opção 'Visualizar Site', se tudo ocorreu bem seu Wpanel CMS já está configurado :)

# Contribuindo com o projeto

## Desenvolvendo

Contribua com o projeto me ajudando a desenvolver, pode começar clonando o repositório e enviando seus 'Pull-Requests'. Envie-me um email em dev[arroba]elieldepaula.com.br para trocarmos informações e manter um contato maior, mesmo que seja uma opinião ou uma dica já estará contribuindo.

##Feedback

Envie sua opinião, dicas e experiências que teve com o Wpanel CMS, todo feedback me ajuda a guiar o desenvolvimento do projeto e dependendo se tornam novas funcionalidades.

##Doando

Doações financeiras são sempre bem vindas e ajudam a manter o foco no projeto evitando ter que dividir o tempo com muitos outros projetos, assim a evolução do projeto é bem mais rápida.

Se você deseja enviar uma doação, entre em contato comigo em dev[arroba]elieldepaula.com.br ou use o botão no site oficial <http://wpanel.org/#download>

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