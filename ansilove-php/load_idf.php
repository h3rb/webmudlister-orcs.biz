<?PHP
/*****************************************************************************/
/*                                                                           */
/* Ansilove/PHP 1.10 (c) by Frederic Cambus 2003-2012                        */
/* http://ansilove.sourceforge.net                                           */
/*                                                                           */
/* Created:      2003/07/17                                                  */
/* Last Updated: 2012/10/08                                                  */
/*                                                                           */
/*****************************************************************************/

error_reporting(E_ALL ^ E_NOTICE);

if (!@require_once(dirname(__FILE__).'/ansilove.php'))
{
   echo "ERROR: Can't load Ansilove library.\n\n";
   exit(-1);
}

if (!@require_once(dirname(__FILE__).'/ansilove.cfg.php'))
{
   echo "ERROR: Can't load Ansilove configuration file.\n\n";
   exit(-1);
}

$input=$_GET['input'];
$bits=$_GET['bits'];

$input=sanitize_input($input);

@load_idf(ANSILOVE_FILES_DIRECTORY.$input,online,$bits);
?>
