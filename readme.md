#Wpanel CMS
##Um CMS desenvolvido com CodeIgniter 2.2.0 fácil de usar.

Wpanel é um CMS (do inglês Content Manager System) ou Gerenciador de Conteúdo para sites que eu desenvolvi para meus projetos de sites em PHP.

A idéia inicial era de ter uma base sólida porém simples, sem milhões de códigos e intermináveis plugins de terçeiros que te deixa com calafrios na hora de dar manutenção. Por isso desenvolvi usando o Framework CodeIgniter por ser simples, robusto e muito rápido, além de ser
muito popular, ter uma ótima documentação e uma boa comunidade.

Há muito o que fazer principalmente sobre a documentação, mas o projeto já está estável e funcionando bem, com um painel de controle responsivo graças ao Bootstrap 3, e um site demonstrativo também responsivo já com uma boa otimização SEO.

É sem dúvida um bom ponto de partida para qualquer projeto. 

Se gostar do CMS e resolver adotá-lo, envie-me um link com seus projetos desenvolvidos para adicionar ao 'Show-Case' em http://wpanelcms.com.br

##Painel de controle

<img src="http://elieldepaula.com.br/_img_wpanel/dashboard.png" alt="Wpanel 12 dashboard.">

##Site de exemplo

<img src="http://elieldepaula.com.br/_img_wpanel/novo-site-preview.png" alt="Site de exemplo http://wpanelcms.com.br/demo">

###Requisitos

- Servidor com PHP 5 e MySql.
- Biblioteca Mcrypt.

###Instalação

- Faça o download ou clone este repositório;
- Carregue todos os arquivos para o servidor onde ficará hospedado ou em seu servidor local;
- Crie uma base de dados e em seguida configure os dados da conexão no arquivo '/app/config/database.php' de acordo com o 'ENVIROMENT' que estiver usando;
- Execute a instalação inicial acessando pelo navegador: http://seusite/index.php/setup
- Na tela seguinte, crie o usuário administrador inicial.
- Acesse o site novamente pelo navegador, o site de exemplo já deve estar funcionando.
- Acesse o painel de controle adicionando /admin à URL.
- É recomendável que remova ou renomeie o controller /app/controllers/setup.php

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
