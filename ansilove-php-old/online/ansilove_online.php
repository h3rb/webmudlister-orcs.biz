<?PHP
/*****************************************************************************/
/*                                                                           */
/* Ansilove/PHP 1.07 (c) by Frederic Cambus 2003-2009                        */
/* http://ansilove.sourceforge.net                                           */
/*                                                                           */
/* Created:      2003/07/17                                                  */
/* Last Updated: 2009/06/14                                                  */
/*                                                                           */
/*****************************************************************************/

if (!@require_once('../ansilove.php'))
{
   echo "ERROR: Can't load Ansilove library.\n\n";
   exit(-1);
}

if (!@require_once('../ansilove.cfg.php'))
{
   echo "ERROR: Can't load Ansilove configuration file.\n\n";
   exit(-1);
}

$columns=$_POST['columns'];
$font=$_POST['font'];
$bits=$_POST['bits'];
$icecolors=$_POST['icecolors'];

$input=$_FILES['input']['name'];
$input_file_tmp_name=$_FILES['input']['tmp_name'];

$input_file_extension=strtolower(substr($input,strlen($input)-4,4));

if (strtolower(substr($input,strlen($input)-3,3))=='.xb')
{
   $input_file_extension='.xb';
}

$input=sanitize_input($input);
$input.=".ansilove";

if (is_uploaded_file($_FILES['input']['tmp_name']))
{
   move_uploaded_file($input_file_tmp_name,ANSILOVE_UPLOAD_DIRECTORY.$input);
}
else
{
   echo "ERROR: $input_file_tmp_name is not an uploaded file.";
   exit;
}

switch ($input_file_extension)
{
case '.pcb':
   load_pcboard(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$font,$bits,$icecolors);
   break;

case '.bin':
   load_binary(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$columns,$font,$bits,$icecolors);
   break;

case '.adf':
   load_adf(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$bits);
   break;

case '.idf':
   load_idf(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$bits);
   break;

case '.tnd':
   load_tundra(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$font,$bits);
   break;

case '.xb':
   load_xbin(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$bits);
   break;

default:
   load_ansi(ANSILOVE_UPLOAD_DIRECTORY.$input,online,$font,$bits,$icecolors);
}

unlink(ANSILOVE_UPLOAD_DIRECTORY.$input);
?>