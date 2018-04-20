<?php
/** 
 * A configuração de base do WordPress
 *
 * Este ficheiro define os seguintes parâmetros: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, e ABSPATH. Pode obter mais informação
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} no Codex. As definições de MySQL são-lhe fornecidas pelo seu serviço de alojamento.
 *
 * Este ficheiro é usado para criar o script  wp-config.php, durante
 * a instalação, mas não tem que usar essa funcionalidade se não quiser. 
 * Salve este ficheiro como "wp-config.php" e preencha os valores.
 *
 * @package WordPress
 */

// ** Definições de MySQL - obtenha estes dados do seu serviço de alojamento** //
/** O nome da base de dados do WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/u197965524/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'u197965524_spd');

/** O nome do utilizador de MySQL */
define('DB_USER', 'u197965524_spd');

/** Redirecionamento do site */
define("WP_SITEURL","http://www.sportpedal.com");

define("WP_HOME","http://www.sportpedal.com/");

/** A password do utilizador de MySQL  */
define('DB_PASSWORD', 'Spd@2016');

/** O nome do serviddor de  MySQL  */
define('DB_HOST', 'mysql.hostinger.com.br');

/** O "Database Charset" a usar na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O "Database Collate type". Se tem dúvidas não mude. */
define('DB_COLLATE', '');

/**#@+
 * Chaves Únicas de Autenticação.
 *
 * Mude para frases únicas e diferentes!
 * Pode gerar frases automáticamente em {@link https://api.wordpress.org/secret-key/1.1/salt/ Serviço de chaves secretas de WordPress.org}
 * Pode mudar estes valores em qualquer altura para invalidar todos os cookies existentes o que terá como resultado obrigar todos os utilizadores a voltarem a fazer login
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+PMu~6{ltjE^Imd@/qv1E6?5b=UV+c:sNa!x):QepkbVdA%Qq8H$F?vTT`avc66W');

define('SECURE_AUTH_KEY',  '3oj]GW-.jzRWEbOAL>F)4{U`WY|,:=GS-A}RX=Ws;0?*UPF/$}$ndT@h/AWQ1nr*');

define('LOGGED_IN_KEY',    '<tI8)kdDkx,:}2{1O=6-OdmLORuQY:w;o/bxH|>u/,iR]e`E.EP:[@b Lw|QaPyd');

define('NONCE_KEY',        'q-N;Sw|v7Vp<.x*Ted!DK: *_S|m.vkw]*c?rwXW NtQBFe-?E,GGcwm=y#C0$M<');

define('AUTH_SALT',        'dU:*={iv#@|qQatuHj0hRHl&!%~NA/:o&mF4DYp~oX% m$%R4el!BWLq{nmTg_hn');

define('SECURE_AUTH_SALT', '8GIvQP1eXBN74=LkuRR<2Q-j1/,iD#{9^j|h!sKn<z`SpHoCUHomc&gs*_sQ8qI!');

define('LOGGED_IN_SALT',   ':EE~|bfS]Dk}A,3..gIm23ce KinA6;7UakpRifm,-QpsUZ%#T0uEQv7`gU&wG.E');

define('NONCE_SALT',       '| G!=|lw!A {TY{R6Km+xbNY(o^ByGan>->Pzg,l/EZGKzo*;vnbd~ nVT%kz5[*');


/**#@-*/

/**
 * Prefixo das tabelas de WordPress.
 *
 * Pode suportar múltiplas instalações numa só base de dados, ao dar a cada
 * instalação um prefixo único. Só algarismos, letras e underscores, por favor!
 */
$table_prefix  = 'wp_';


/**
 * Idioma de Localização do WordPress, Inglês por omissão.
 *
 * Mude isto para localizar o WordPress. Um ficheiro MO correspondendo ao idioma
 * escolhido deverá existir na directoria wp-content/languages. Instale por exemplo
 * pt_PT.mo em wp-content/languages e defina WPLANG como 'pt_PT' para activar o
 * suporte para a língua portuguesa.
 */
define('WPLANG', 'pt_PT');

/**
 * Para developers: WordPress em modo debugging.
 *
 * Mude isto para true para mostrar avisos enquanto estiver a testar.
 * É vivamente recomendado aos autores de temas e plugins usarem WP_DEBUG
 * no seu ambiente de desenvolvimento.
 */
define('WP_DEBUG', false);

/* E é tudo. Pare de editar! */

/** Caminho absoluto para a pasta do WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Define as variáveis do WordPress e ficheiros a incluir. */
require_once(ABSPATH . 'wp-settings.php');
