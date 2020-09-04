# Welcome to Wpanel CMS

*Build Blogs, Websites and Web Apps with an CMS made in top of CodeIgniter 3.x*

This project was born from the need to create a fast and easy website without using solutions like Wordpress or Joomla, which due to the amount of code and third party plugins increases the complexity of any changes.

The objective of this project is to assist developers who want to have code control in a simple and practical way.

Wpanel was developed on the Codeigniter 3 framework, so it is important to have some basic knowledge of its operation. See the Codeigniter 3 [documentation here](https://codeigniter.com/userguide3/index.html).

# Features

1. Responsive administrator thanks to AdminLTE.
2. Account management with ACL granting access by URI.
3. Posts - can be News or just a Blog on your website.
4. Pages - manage your site's fixed pages, such as the 'About' page.
5. Banners - Manage the slide banner of the home page.
6. Galleries - Manage the photo galleries on the site.
7. Youtube videos.
8. Menu management.
9. Newsletters - Collect leads on your website.
10. Account management.
11. Dynamic settings.

# Wpanel require

1. Functional webserver
2. PHP 7.x
4. MySQL or SQLite3

# Quick start

The easiest way to have Wpanel CMS ready to start developing your project is through [Composer](https://getcomposer.org), with the SQLite database and using the built-in PHP server. To do this, follow the steps below.

- Run the composer command to create your project:
```sh
composer create-project "wpanel/wpanel4-cms" Blog
```

- Access the Blog folder created in the previous step and run the start script:
```sh
cd Blog
composer run dev
```

- Run the installation of Wpanel with accessing http://localhost:8080/index.php/setup
- Fill the form with the ROOT administrator data
- Access the admin area using the data provided in the previous step
- Done! Wpanel is already running at http://localhost:8080

For more installation details and advanced configurations topics, acces the [Wiki of the project.](https://github.com/wpanel/wpanel4-cms/wiki)

# Contributing

*See how to contribute to this project:*

## 1 - Development

If you're a web developer and want to be part of an cool project, you're in the right place! Fork the project and send your Pull-requests. Also you can send me a email to *dev[at]elieldepaula.com.br* so we can change ideas and to plan some features to the project.

I also recommend you to read the CodeIgniter [Style Guide](https://codeigniter.com/userguide3/general/styleguide.html) on a try to make the code in the same pattern.

## 2 - Feedback

Send your feedback about the project, you can send an email to *dev[at]elieldepaula.com.br* or send a message in our [page on Facebook](https://www.facebook.com/wpanelcms/). If you have experienced bugs you can inform them in the [issues section](https://github.com/elieldepaula/wpanel/issues) here on github. And do not forget to send your ideas and demands to the project, we want to hear what you are meant to do with Wpanel and help you.

## 3 - Donate

Financial donating is always welcome and they help us to keep focus on the project, then the evolution could be more fast.

You'll find two buttons of donation [in the oficial site](http://wpanel.org/#download), one for PayPal and another to PagSeguro.

Feel free to send an email to dev[at]elieldepaula.com.br and get more informations about others ways to donate.

# License

This is a personal project I have been working on for several years and I am making it available under the MIT license, you can use it any way you want, but without any warranty. In the development process I learned a lot and grew as a developer and I'm happy to extend this project to you.

# The MIT License (MIT)

Copyright (c) 2020 Eliel de Paula
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