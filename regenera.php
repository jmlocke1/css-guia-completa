<?php
// Definimos el directorio padre del sistema
define("DIR_ROOT", __DIR__);

/**
 * Declaraciones de repositorios.
 * La estructura es la siguiente:
 * 		name: Nombre del repositorio
 * 		repo: repositorio github
 * 		url: ruta relativa hasta el repositorio. Se puede añadir una o más carpetas, luego se  crean las necesarias
 */
$subdomain = [
	
];
$noSubdomain = [
	[
		'name' => 'tienda-muebles',
		'repo' => 'git@github.com:jmlocke1/tienda-muebles.git',
		'url' => '06-ecommerce'
	],
	[
		'name' => 'tech-pro',
		'repo' => 'git@github.com:jmlocke1/tech-pro.git',
		'url' => '07-audifonos'
	],
	[
		'name' => 'arquitectura-bosque',
		'repo' => 'git@github.com:jmlocke1/arquitectura-bosque.git',
		'url' => '08-arquitectura'
	],
	[
		'name' => 'nucleus',
		'repo' => 'git@github.com:jmlocke1/nucleus.git',
		'url' => '10-nucleus'
	],
	[
		'name' => 'cafeteria',
		'repo' => 'git@github.com:jmlocke1/cafeteria.git',
		'url' => '11-cafeteria'
	]
];
// Funciones
function escribe($fichero, $texto) {
	$filephp = fopen($fichero, "w");
	fwrite($filephp, $texto);
	fclose($filephp);
}

function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
$texto = '';

// Fichero para clonar todos los repositorios
// Windows
if(!empty($subdomain)){
	$texto = "@REM Repositorios con subdominio".PHP_EOL.PHP_EOL;

	foreach($subdomain as $repo){
		$texto .= "git clone {$repo['repo']}".PHP_EOL;
	}
	$texto .= PHP_EOL.PHP_EOL;
}
if(!empty($noSubdomain)){
	$texto .= "@REM Repositorios sin subdominio".PHP_EOL.PHP_EOL;
	foreach($noSubdomain as $repo){
		$texto .= "git clone {$repo['repo']} {$repo['url']}/{$repo['name']}".PHP_EOL;
	}
}

escribe('clonesub.bat', $texto);

// Linux
$texto = <<<PRE
#!/bin/bash
# -*- ENCODING: UTF-8 -*-

PRE;
if(!empty($subdomain)) {
	$texto .= <<<PRE

# Repositorios con subdominio


PRE;
	foreach($subdomain as $repo){
		$texto .= "git clone {$repo['repo']}".PHP_EOL;
	}
	$texto .= PHP_EOL.PHP_EOL;
}
if(!empty($noSubdomain)) {
	$texto .= "# Repositorios sin subdominio".PHP_EOL.PHP_EOL;
	foreach($noSubdomain as $repo){
		$texto .= "git clone {$repo['repo']} {$repo['url']}/{$repo['name']}".PHP_EOL;
	}
}

escribe('clonesub.sh', $texto);

// Fichero para obtener los cambios de todos los repositorios
// incluido el repositorio raíz
// Windows
$texto = <<<PRE
@REM Primero obtenemos los cambios del repositorio actual
git pull

PRE;
if(!empty($subdomain)) {
	$texto .= <<<PRE

@REM Repositorios con subdominio


PRE;
	foreach($subdomain as $repo){
		$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git pull
cd ..
cd ..

PRE;
	}
}
if(!empty($noSubdomain)) {
	$texto .= <<<PRE
@REM Repositorios sin subdominio


PRE;
	foreach($noSubdomain as $repo){
		$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git pull
cd ..
cd ..

PRE;
	}
}

escribe('pull.bat', $texto);

// Linux

$texto = <<<PRE
#!/bin/bash
# -*- ENCODING: UTF-8 -*-

# Primero obtenemos los cambios del repositorio actual
git pull

PRE;
if(!empty($subdomain)) {
	$texto .= <<<PRE

# Repositorios con subdominio


PRE;
	foreach($subdomain as $repo){
		$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git pull
cd ..
cd ..

PRE;
	}
}
if(!empty($noSubdomain)) {
	$texto .= <<<PRE
# Repositorios sin subdominio


PRE;
	foreach($noSubdomain as $repo){
		$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git pull
cd ..
cd ..

PRE;
	}
}

escribe('pull.sh', $texto);

// Fichero para subir los cambios de todos los repositorios
// Aunque no es muy recomendable, mejor subir los cambios de uno en uno
// Windows
$texto = "@REM Repositorios con subdominio".PHP_EOL.PHP_EOL;
foreach($subdomain as $repo){
	$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git push
cd ..
cd ..

PRE;
}
$texto .= <<<PRE


@REM Repositorios sin subdominio


PRE;
foreach($noSubdomain as $repo){
	$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git push
cd ..
cd ..

PRE;
}
escribe('push.bat', $texto);

// Linux
$texto = <<<PRE
#!/bin/bash
# -*- ENCODING: UTF-8 -*-

PRE;
$texto .= "# Repositorios con subdominio".PHP_EOL.PHP_EOL;
foreach($subdomain as $repo){
	$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git push
cd ..
cd ..

PRE;
}
$texto .= <<<PRE


# Repositorios sin subdominio


PRE;
foreach($noSubdomain as $repo){
	$texto .= <<<PRE
cd {$repo['url']}
cd {$repo['name']}
git push
cd ..
cd ..

PRE;
}
escribe('push.sh', $texto);