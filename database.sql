-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 18/12/2014 às 22:56
-- Versão do servidor: 5.5.40-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `wpanel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `albuns`
--

CREATE TABLE IF NOT EXISTS `albuns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descricao` mediumtext,
  `capa` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `position` varchar(20) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `content` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_banners_usuarios1_idx` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `banners`
--

INSERT INTO `banners` (`id`, `title`, `position`, `order`, `type`, `content`, `created`, `updated`, `status`, `user_id`) VALUES
(1, 'Benner de exemplo #1', 'slide', 1, NULL, '75a85d7bed6fbba7d81ba03fca10c382.jpg', '2014-10-23 12:59:04', '2014-12-18 20:10:51', '1', 0),
(5, 'Benner de exemplo #2', 'slide', 2, NULL, '0c94f325b87fecfb67ef14821dbe1be4.jpg', '2014-11-11 09:44:13', '2014-12-18 20:10:59', '1', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `link` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `view` varchar(45) DEFAULT 'Lista',
  PRIMARY KEY (`id`),
  KEY `fk_categories_categories1_idx` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `categories`
--

INSERT INTO `categories` (`id`, `title`, `link`, `description`, `category_id`, `view`) VALUES
(1, 'Categoria de exemplo', 'Categoria-de-exemplo', '', 0, 'Lista'),
(2, 'Sub-categoria de exemplo', 'Sub-categoria-de-exemplo', '', 1, 'Lista');

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE IF NOT EXISTS `configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_titulo` varchar(100) DEFAULT NULL,
  `site_desc` text,
  `site_tags` text,
  `site_contato` varchar(60) DEFAULT NULL,
  `site_telefone` varchar(15) DEFAULT NULL,
  `link_instagram` varchar(100) DEFAULT NULL,
  `link_twitter` varchar(100) DEFAULT NULL,
  `link_facebook` varchar(100) DEFAULT NULL,
  `link_likebox` varchar(100) DEFAULT NULL,
  `copyright` text,
  `addthis_uid` varchar(30) DEFAULT NULL,
  `logomarca` varchar(200) DEFAULT NULL,
  `background` varchar(200) DEFAULT NULL,
  `bgcolor` varchar(15) DEFAULT NULL,
  `texto_contato` text,
  `usa_smtp` tinyint(1) NOT NULL,
  `smtp_servidor` varchar(100) NOT NULL,
  `smtp_porta` int(3) NOT NULL,
  `smtp_usuario` varchar(100) NOT NULL,
  `smtp_senha` varchar(100) NOT NULL,
  `youtube_rss` varchar(200) DEFAULT NULL,
  `google_analytics` text,
  `home_tipo` varchar(10) DEFAULT NULL,
  `home_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `site_titulo`, `site_desc`, `site_tags`, `site_contato`, `site_telefone`, `link_instagram`, `link_twitter`, `link_facebook`, `link_likebox`, `copyright`, `addthis_uid`, `logomarca`, `background`, `bgcolor`, `texto_contato`, `usa_smtp`, `smtp_servidor`, `smtp_porta`, `smtp_usuario`, `smtp_senha`, `youtube_rss`, `google_analytics`, `home_tipo`, `home_id`) VALUES
(1, 'WPanel CMS', 'Este é um site-exemplo usando WPanel CMS', 'wpanel, cms, codeigniter, demonstração', 'dev@elieldepaula.com.br', '', 'http://instagram.com.br/elieldepaula', 'http://twitter.com/elielulisses', 'http://facebook.com/elieldepaula', 'http://facebook.com/dotsistemas', '® 2014 wPanel - Direitos reservados', '', 'logomarca.png', 'background.jpg', '', '<p>Esta &eacute; uma mensagem adicional &agrave; p&aacute;gina de contato, use-a para passar maiores informa&ccedil;&otilde;es de contato como endere&ccedil;o, telefones adicionais etc.</p>\n', 0, 'mail.elieldepaula.com.br', 25, '', '', 'http://gdata.youtube.com/feeds/api/users/HBvideochannel/uploads', '', 'category', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos`
--

CREATE TABLE IF NOT EXISTS `fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_email`
--

CREATE TABLE IF NOT EXISTS `newsletter_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `tags` text,
  `status` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `page` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_posts_usuarios1_idx` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Fazendo dump de dados para tabela `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `link`, `content`, `created`, `updated`, `image`, `tags`, `status`, `user_id`, `page`) VALUES
(1, 'Página inicial', 'Página inicial de exemplo do WPanel', 'pagina-inicial', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n', '2014-11-09 23:17:53', '2014-12-18 20:09:59', '0', 'wpanel, bem vindo, exemplo', '1', 1, 1),
(2, 'Sobre', 'Um exemplo de página específica para o menu.', 'sobre', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-09 23:29:16', '2014-11-09 23:29:16', '0', 'exemplo, pagina, sobre', '1', 1, 1),
(3, 'Postagem de exemplo', 'Exemplo de postagem', 'postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-09 23:46:38', '2014-11-10 00:04:22', '3b97b0a585305535f5c86f35ef108adb.png', 'demo, post, wpanel', '1', 1, 0),
(4, 'Segunda postagem de exemplo', 'Postagem de exemplo do Wpanel', 'segunda-postagem-de-exemplo', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rhoncus justo ex, sit amet malesuada mauris aliquam eu. Duis sed magna neque. Sed vel urna elit. Maecenas lacinia blandit felis, sed scelerisque dolor faucibus non. In consequat elit sed risus hendrerit, at bibendum elit efficitur. Nulla nulla nunc, sagittis at tellus non, hendrerit euismod elit. Morbi lacinia leo eget diam sodales dignissim. Curabitur vel turpis et dolor vehicula rutrum. Quisque magna magna, accumsan et justo a, malesuada convallis metus. Nam pharetra congue metus vitae sodales.</p>\n\n<p>Mauris varius nunc sit amet tellus semper, rutrum feugiat justo tempor. Curabitur vestibulum sem eleifend ex imperdiet, sit amet porta mi bibendum. Proin eget interdum nunc. Proin ullamcorper mi eget leo tempus mattis eu non ex. Proin porta vitae sem sit amet tempor. Nullam lacus risus, iaculis ut massa in, suscipit elementum ex. Etiam iaculis sit amet nulla at mattis. Fusce eget facilisis nibh, ut scelerisque mauris. Proin elementum erat quis leo accumsan auctor. Phasellus sodales justo ac bibendum ornare. Morbi venenatis, mauris nec ultrices volutpat, nibh felis sagittis leo, nec imperdiet nisl diam id tortor. Proin pulvinar augue dolor, vel pulvinar arcu consequat nec. Fusce faucibus nulla ut nisl efficitur dignissim.</p>\n\n<p>Proin eget est ornare, tempor elit quis, mattis diam. Mauris lobortis lectus sit amet enim bibendum cursus. Donec porta ultrices consectetur. Proin vehicula fringilla dolor nec viverra. Donec faucibus risus et mauris rhoncus lobortis. Vestibulum ac maximus ipsum. Fusce non diam semper, laoreet ipsum at, sagittis nisl. Mauris a luctus erat, in venenatis tellus.</p>\n\n<p>&nbsp;</p>\n', '2014-11-09 23:47:15', '2014-11-10 01:12:01', '5d8e88d1e7a12a8bc9c172e07410f0dc.png', 'demo, post, exemplo, wpanel', '1', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts_categories`
--

CREATE TABLE IF NOT EXISTS `posts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT '  \n\n  ',
  PRIMARY KEY (`id`),
  KEY `fk_posts_has_categories_categories1_idx` (`category_id`),
  KEY `fk_posts_has_categories_posts1_idx` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `posts_categories`
--

INSERT INTO `posts_categories` (`id`, `post_id`, `category_id`) VALUES
(1, 3, 1),
(2, 4, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albuns` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
