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

/*****************************************************************************/
/* SECURITY WARNING!           SECURITY WARNING!           SECURITY WARNING! */
/*                                                                           */
/* Don't unset the ANSILOVE_FILES_DIRECTORY defined  constant, else it'll be */
/* possible to convert files  laying in the same directory than the loaders, */
/* which could lead to possible security leaks.                              */
/*                                                                           */
/* SECURITY WARNING!           SECURITY WARNING!           SECURITY WARNING! */
/*****************************************************************************/

DEFINE (ANSILOVE_FILES_DIRECTORY,"../cache/");
DEFINE (ANSILOVE_UPLOAD_DIRECTORY,"upload/");

DEFINE (PCBOARD_STRIP_CODES,"@POFF@,@WAIT@");

DEFINE (DIZ_EXTENSIONS,".diz,.ion");

DEFINE (CED_BACKGROUND_COLOR,"168,168,168");
DEFINE (CED_FOREGROUND_COLOR,"0,0,0");

DEFINE (THUMBNAILS_HEIGHT,"0");
DEFINE (THUMBNAILS_TAG,"-thumbnail");
?>
