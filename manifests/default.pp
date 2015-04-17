#Apache install
package { 'httpd':
	ensure => installed,
} ->
file { 'httpd.conf':
	path => '/etc/httpd/conf/httpd.conf',
	ensure => present,
	source => '/vagrant/config_file/httpd.conf',
	owner => root,
	group => root,
	mode => 0644,
}
service { 'httpd':
	enable      => true,
	ensure      => running,
	subscribe => [File['httpd.conf'], File['php.ini']]
}

#PHP install
package { 'php56w':
	ensure => installed,
}->
package { 'php56w-mcrypt':
	ensure => installed,
}->
package { 'php56w-mbstring':
	ensure => installed,
}->
package { 'php56w-devel':
	ensure => installed,
}->
package { 'php56w-pear':
	ensure => installed,
}->
package { 'php56w-pdo':
	ensure => installed,
}->
package { 'php56w-mysql':
	ensure => installed,
}->
exec { 'xdebug':
	unless => 'pecl list | grep xdebug',
	command => 'pecl install xdebug',
	path => "/usr/bin",
} ->
file { 'php.ini':
	path => '/etc/php.ini',
	ensure => present,
	source => '/vagrant/config_file/php.ini',
	owner => root,
	group => root,
	mode => 0644,
}->
exec { 'composer':
	command      => 'curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer',
	path => ["/usr/local/bin", "/usr/bin"],
}