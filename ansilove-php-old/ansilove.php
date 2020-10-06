<?PHP
error_reporting(0);
/*****************************************************************************/
/*                                                                           */
/* Ansilove/PHP 1.07 (c) by Frederic Cambus 2003-2009                        */
/* http://ansilove.sourceforge.net                                           */
/*                                                                           */
/* Created:      2003/07/17                                                  */
/* Last Updated: 2009/06/16                                                  */
/*                                                                           */
/* This program is free software; you can redistribute it and/or modify      */
/* it under the terms of the GNU General Public License as published by      */
/* the Free Software Foundation; either version 2 of the License, or         */
/* (at your option) any later version.                                       */
/*                                                                           */
/* This program is distributed in the hope that it will be useful,           */
/* but WITHOUT ANY WARRANTY; without even the implied warranty of            */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             */
/* GNU General Public License for more details.                              */
/*                                                                           */
/* You should have received a copy of the GNU General Public License         */
/* along with this program; if not, write to the Free Software               */
/* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA */
/*                                                                           */
/*****************************************************************************/

/*****************************************************************************/
/* LOAD CONFIGURATION FILE                                                   */
/*****************************************************************************/

if (!@require_once(dirname(__FILE__).'/ansilove.cfg.php'))
{
   echo "ERROR: Can't load Ansilove configuration file.\n\n";
   exit(-1);
}

/*****************************************************************************/
/* SANITIZE INPUT                                                            */
/*****************************************************************************/

function sanitize_input($input)
{
   $input=ereg_replace("/","",$input);
   $input=ereg_replace("%2f","",$input);
   $input=ereg_replace("\.\.","",$input);

   return $input;
}



/*****************************************************************************/
/* CHECK LIBRARIES                                                           */
/*****************************************************************************/

function check_libraries()
{
   if (!extension_loaded('gd'))
   {
      echo "ERROR: Ansilove requires GD library.\n\n";
      exit(-1);
   }
}



/*****************************************************************************/
/* LOAD ANSI                                                                 */
/*****************************************************************************/

function load_ansi($input,$output,$font,$bits,$icecolors)
{
   check_libraries();

/*****************************************************************************/
/* CHECK PARAMETERS AND FORCE DEFAULT VALUES IF INVALID INPUT IS DETECTED    */
/*****************************************************************************/

   $columns=80;

   $ced=0;

   if ($bits=='ced')
   {
      $ced=1;
   }
   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }
   if ($bits!=8 && $bits!=9)
   {
      $bits=8;
   }

   switch($font)
   {
   case '80x25':
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case '80x50':
      $font_file='ansilove_font_pc_80x50.png';
      $font_size_x=9;
      $font_size_y=8;
      break;

   case 'armenian':
      $font_file='ansilove_font_pc_armenian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'baltic':
      $font_file='ansilove_font_pc_baltic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'cyrillic':
      $font_file='ansilove_font_pc_cyrillic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'french-canadian':
      $font_file='ansilove_font_pc_french_canadian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek':
      $font_file='ansilove_font_pc_greek.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek-869':
      $font_file='ansilove_font_pc_greek_869.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'hebrew':
      $font_file='ansilove_font_pc_hebrew.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'icelandic':
      $font_file='ansilove_font_pc_icelandic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin1':
      $font_file='ansilove_font_pc_latin1.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin2':
      $font_file='ansilove_font_pc_latin2.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'nordic':
      $font_file='ansilove_font_pc_nordic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'persian':
      $font_file='ansilove_font_pc_persian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'portuguese':
      $font_file='ansilove_font_pc_portuguese.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'russian':
      $font_file='ansilove_font_pc_russian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'turkish':
      $font_file='ansilove_font_pc_turkish.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'amiga':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'b-strict':
      $font_file='ansilove_font_b-strict.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'b-struct':
      $font_file='ansilove_font_b-struct.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'microknight':
      $font_file='ansilove_font_microknight.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'mosoul':
      $font_file='ansilove_font_mosoul.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'pot-noodle':
      $font_file='ansilove_font_pot-noodle.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz':
      $font_file='ansilove_font_topaz.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz+':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topazplus':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   default:
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
   }



/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);

   $diz_extensions_exploded=explode(",",DIZ_EXTENSIONS);

   for ($loop=0;$loop<sizeof($diz_extensions_exploded);$loop++)
   {
      $diz_extension_length=strlen($diz_extensions_exploded[$loop]);

      if (strtolower(substr($input,(strlen($input)-$diz_extension_length),$diz_extension_length))==$diz_extensions_exploded[$loop] || strtolower(substr($input,strlen($input)-($diz_extension_length+9),($diz_extension_length+9)))==$diz_extensions_exploded[$loop].'.ansilove')
      {
         $input_file_buffer=preg_replace("/^(\s+[\r\n])+/","",$input_file_buffer);
         $input_file_buffer=rtrim($input_file_buffer);
         $input_file_size=strlen($input_file_buffer);
      }
   }

/*****************************************************************************/
/* LOAD BACKGROUND/FONT                                                      */
/*****************************************************************************/

   if (!$background = imagecreatefrompng(dirname(__FILE__).'/fonts/ansilove_background.png'))
   {
      echo "ERROR: Can't open file ansilove_background.png\n\n";
      exit(-1);
   }

   if (!$font = imagecreatefrompng(dirname(__FILE__).'/fonts/'.$font_file))
   {
      echo "ERROR: Can't open file $font_file\n\n";
      exit(-1);
   }

   imagecolortransparent($font,20);



/*****************************************************************************/
/* ALLOCATE BACKGROUND/FOREGROUND COLOR ARRAYS                               */
/*****************************************************************************/

   $background_colors[40]=0;  $background_colors[41]=4;  $background_colors[42]=2;
   $background_colors[43]=6;  $background_colors[44]=1;  $background_colors[45]=5;
   $background_colors[46]=3;  $background_colors[47]=7;

   $foreground_colors[20]=8;  $foreground_colors[21]=12; $foreground_colors[22]=10;
   $foreground_colors[23]=14; $foreground_colors[24]=9;  $foreground_colors[25]=13;
   $foreground_colors[26]=11; $foreground_colors[27]=15;

   $foreground_colors[30]=0;  $foreground_colors[31]=4;  $foreground_colors[32]=2;
   $foreground_colors[33]=6;  $foreground_colors[34]=1;  $foreground_colors[35]=5;
   $foreground_colors[36]=3;  $foreground_colors[37]=7;



/*****************************************************************************/
/* PROCESS ANSI                                                              */
/*****************************************************************************/

   $color_background=0;
   $color_foreground=7;

   $loop=0;

   $position_x=0;
   $position_y=0;

   $position_x_max=0;
   $position_y_max=0;

   while ($loop<$input_file_size)
   {
      $current_character=ord($input_file_buffer[$loop]);
      $next_character=ord($input_file_buffer[$loop+1]);

      if ($position_x==80)
      {
         $position_y++;
         $position_x=0;
      }

/*****************************************************************************/
/* CR+LF                                                                     */
/*****************************************************************************/

      if ($current_character==13)
      {
         if ($next_character==10)
         {
            $position_y++;
            $position_x=0;
            $loop++;
         }
      }

/*****************************************************************************/
/* LF                                                                        */
/*****************************************************************************/

      if ($current_character==10)
      {
         $position_y++;
         $position_x=0;
      }

/*****************************************************************************/
/* TAB                                                                       */
/*****************************************************************************/

      if ($current_character==9)
      {
         $position_x+=8;
      }

/*****************************************************************************/
/* SUB                                                                       */
/*****************************************************************************/

      if ($current_character==26)
      {
         break;
      }



/*****************************************************************************/
/* ANSI SEQUENCE                                                             */
/*****************************************************************************/

      if ($current_character==27 && $next_character==91)
      {
         unset($ansi_sequence);

         for ($ansi_sequence_loop=0;$ansi_sequence_loop<12;$ansi_sequence_loop++)
         {
            $ansi_sequence_character=$input_file_buffer[$loop+2+$ansi_sequence_loop];

/*****************************************************************************/
/* CURSOR POSITION                                                           */
/*****************************************************************************/

            if ($ansi_sequence_character=='H' || $ansi_sequence_character=='f')
            {
               $ansi_sequence_exploded=explode(";",$ansi_sequence);
               $position_y=$ansi_sequence_exploded[0]-1;
               $position_x=$ansi_sequence_exploded[1]-1;

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* CURSOR UP                                                                 */
/*****************************************************************************/

            if ($ansi_sequence_character=='A')
            {
               if ($ansi_sequence=='')
               {
                  $ansi_sequence=1;
               }

               $position_y=$position_y-$ansi_sequence;

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* CURSOR DOWN                                                               */
/*****************************************************************************/

            if ($ansi_sequence_character=='B')
            {
               if ($ansi_sequence=='')
               {
                  $ansi_sequence=1;
               }

               $position_y=$position_y+$ansi_sequence;

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* CURSOR FORWARD                                                            */
/*****************************************************************************/

            if ($ansi_sequence_character=='C')
            {
               if ($ansi_sequence=='')
               {
                  $ansi_sequence=1;
               }

               $position_x=$position_x+$ansi_sequence;
               if ($position_x>80)
               {
                  $position_x=80;
               }

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* CURSOR BACKWARD                                                           */
/*****************************************************************************/

            if ($ansi_sequence_character=='D')
            {
               if ($ansi_sequence=='')
               {
                  $ansi_sequence=1;
               }

               $position_x=$position_x-$ansi_sequence;
               if ($position_x<0)
               {
                  $position_x=0;
               }

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* SAVE CURSOR POSITION                                                      */
/*****************************************************************************/

            if ($ansi_sequence_character=='s')
            {
               $saved_position_y=$position_y;
               $saved_position_x=$position_x;

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* RESTORE CURSOR POSITION                                                   */
/*****************************************************************************/

            if ($ansi_sequence_character=='u')
            {
               $position_y=$saved_position_y;
               $position_x=$saved_position_x;

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* ERASE DISPLAY                                                             */
/*****************************************************************************/

            if ($ansi_sequence_character=='J')
            {
               if ($ansi_sequence==2)
               {
                  unset($ansi_buffer);

                  $position_x=0;
                  $position_y=0;

                  $position_x_max=0;
                  $position_y_max=0;
               }

               $loop+=$ansi_sequence_loop+2;
               break;
            }

/*****************************************************************************/
/* SET GRAPHIC RENDITION                                                     */
/*****************************************************************************/

            if ($ansi_sequence_character=='m')
            {
               $ansi_sequence_exploded=explode(";",$ansi_sequence);

               sort($ansi_sequence_exploded);

               for ($loop_ansi_sequence=0;$loop_ansi_sequence<sizeof($ansi_sequence_exploded);$loop_ansi_sequence++)
               {
                  $ansi_sequence_value=$ansi_sequence_exploded[$loop_ansi_sequence];

                  if ($ansi_sequence_value==0)
                  {
                     $color_background=0;
                     $color_foreground=7;
                     $bold=0;
                     $blink=0;
                  }

                  if ($ansi_sequence_value==1)
                  {
                     $color_foreground+=8;
                     $bold=1;
                  }

                  if ($ansi_sequence_value==5)
                  {
                     $color_background+=8;
                     $blink=1;
                  }

                  if ($ansi_sequence_value>29 && $ansi_sequence_value<40)
                  {
                     if ($bold==1)
                     {
                        $ansi_sequence_value=$ansi_sequence_value-10;
                     }
                     $color_foreground=$foreground_colors[$ansi_sequence_value];
                  }

                  if ($ansi_sequence_exploded[$loop_ansi_sequence]>39 && $ansi_sequence_exploded[$loop_ansi_sequence]<50)
                  {
                     if ($blink==1 && $icecolors==1)
                     {
                        $ansi_sequence_value=$ansi_sequence_value-20;
                        $color_background=$foreground_colors[$ansi_sequence_value];
                     }
                     else
                     {
                        $color_background=$background_colors[$ansi_sequence_value];
                     }
                  }
               }

               $loop+=$ansi_sequence_loop+2;
               break;
            }
            $ansi_sequence.=$ansi_sequence_character;
         }
      }
      elseif ($current_character!=10 && $current_character!=13 && $current_character!=9)
      {

/*****************************************************************************/
/* RECORD NUMBER OF COLUMNS AND LINES USED                                   */
/*****************************************************************************/

         if ($position_x>$position_x_max)
         {
            $position_x_max=$position_x;
         }

         if ($position_y>$position_y_max)
         {
            $position_y_max=$position_y;
         }



/*****************************************************************************/
/* WRITE CURRENT CHARACTER INFO IN A TEMPORARY ARRAY                         */
/*****************************************************************************/

         $ansi_buffer[]=$position_x;
         $ansi_buffer[]=$position_y;
         $ansi_buffer[]=$color_background;
         $ansi_buffer[]=$color_foreground;
         $ansi_buffer[]=$current_character;

         $position_x++;
      }
      $loop++;
   }



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   $position_x_max++;
   $position_y_max++;

   if ($ced==1)
   {
      $columns=78;
   }

   for ($loop=0;$loop<sizeof($diz_extensions_exploded);$loop++)
   {
      $diz_extension_length=strlen($diz_extensions_exploded[$loop]);

      if (strtolower(substr($input,(strlen($input)-$diz_extension_length),$diz_extension_length))==$diz_extensions_exploded[$loop] || strtolower(substr($input,strlen($input)-($diz_extension_length+9),($diz_extension_length+9)))==$diz_extensions_exploded[$loop].'.ansilove')
      {
         $columns=min($position_x_max,80);
      }
   }

   if (!$ansi = imagecreate($columns*$bits,($position_y_max)*$font_size_y))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   if ($ced==1)
   {
      $ced_background_color=explode(",",CED_BACKGROUND_COLOR);
      $ced_foreground_color=explode(",",CED_FOREGROUND_COLOR);

      imagecolorallocate($ansi,$ced_background_color[0],$ced_background_color[1],$ced_background_color[2]);

      $ced_color=imagecolorallocate($ansi,$ced_background_color[0],$ced_background_color[1],$ced_background_color[2]);
      $ced_color=imagecolorallocate($background,$ced_background_color[0],$ced_background_color[1],$ced_background_color[2]);

      imagefill($ansi,0,0,$ced_color);
      imagefilledrectangle($background,0,0,144,16,$ced_color);

      for ($loop=0;$loop<16;$loop++)
      {
         imagecolorset($font,$loop,$ced_foreground_color[0],$ced_foreground_color[1],$ced_foreground_color[2]);
      }
   }
   else
   {
      imagecolorallocate($ansi,0,0,0);
   }



/*****************************************************************************/
/* RENDER ANSI                                                               */
/*****************************************************************************/

   for ($loop=0;$loop<sizeof($ansi_buffer);$loop+=5)
   {
      $position_x=$ansi_buffer[$loop];
      $position_y=$ansi_buffer[$loop+1];
      $color_background=$ansi_buffer[$loop+2];
      $color_foreground=$ansi_buffer[$loop+3];
      $character=$ansi_buffer[$loop+4];

      imagecopy($ansi,$background,$position_x*$bits,$position_y*$font_size_y,$color_background*9,0,$bits,$font_size_y);
      imagecopy($ansi,$font,$position_x*$bits,$position_y*$font_size_y,$character*$font_size_x,$color_foreground*$font_size_y,$bits,$font_size_y);
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$ansi,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($ansi);
      }
      else
      {
         ImagePNG($ansi,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($ansi);
   imagedestroy($background);
   imagedestroy($font);
}



/*****************************************************************************/
/* LOAD PCBOARD                                                              */
/*****************************************************************************/

function load_pcboard($input,$output,$font,$bits)
{
   check_libraries();

/*****************************************************************************/
/* CHECK PARAMETERS AND FORCE DEFAULT VALUES IF INVALID INPUT IS DETECTED    */
/*****************************************************************************/

   $columns=80;

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }
   if ($bits!=8 && $bits!=9)
   {
      $bits=8;
   }

   switch($font)
   {
   case '80x25':
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case '80x50':
      $font_file='ansilove_font_pc_80x50.png';
      $font_size_x=9;
      $font_size_y=8;
      break;

   case 'armenian':
      $font_file='ansilove_font_pc_armenian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'baltic':
      $font_file='ansilove_font_pc_baltic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'cyrillic':
      $font_file='ansilove_font_pc_cyrillic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'french-canadian':
      $font_file='ansilove_font_pc_french_canadian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek':
      $font_file='ansilove_font_pc_greek.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek-869':
      $font_file='ansilove_font_pc_greek_869.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'hebrew':
      $font_file='ansilove_font_pc_hebrew.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'icelandic':
      $font_file='ansilove_font_pc_icelandic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin1':
      $font_file='ansilove_font_pc_latin1.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin2':
      $font_file='ansilove_font_pc_latin2.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'nordic':
      $font_file='ansilove_font_pc_nordic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'persian':
      $font_file='ansilove_font_pc_persian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'portuguese':
      $font_file='ansilove_font_pc_portuguese.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'russian':
      $font_file='ansilove_font_pc_russian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'turkish':
      $font_file='ansilove_font_pc_turkish.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'amiga':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'b-strict':
      $font_file='ansilove_font_b-strict.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'b-struct':
      $font_file='ansilove_font_b-struct.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'microknight':
      $font_file='ansilove_font_microknight.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'mosoul':
      $font_file='ansilove_font_mosoul.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'pot-noodle':
      $font_file='ansilove_font_pot-noodle.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz':
      $font_file='ansilove_font_topaz.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz+':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topazplus':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   default:
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
   }



/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* LOAD BACKGROUND/FONT                                                      */
/*****************************************************************************/

   if (!$background = imagecreatefrompng(dirname(__FILE__).'/fonts/ansilove_background.png'))
   {
      echo "ERROR: Can't open file ansilove_background.png\n\n";
      exit(-1);
   }

   if (!$font = imagecreatefrompng(dirname(__FILE__).'/fonts/'.$font_file))
   {
      echo "ERROR: Can't open file $font_file\n\n";
      exit(-1);
   }

   imagecolortransparent($font,20);

/*****************************************************************************/
/* ALLOCATE BACKGROUND/FOREGROUND COLOR ARRAYS                               */
/*****************************************************************************/

   $pcb_colors[48]=0;   $pcb_colors[49]=1;   $pcb_colors[50]=2;
   $pcb_colors[51]=3;   $pcb_colors[52]=4;   $pcb_colors[53]=5;
   $pcb_colors[54]=6;   $pcb_colors[55]=7;   $pcb_colors[56]=8;
   $pcb_colors[57]=9;   $pcb_colors[65]=10;  $pcb_colors[66]=11;
   $pcb_colors[67]=12;  $pcb_colors[68]=13;  $pcb_colors[69]=14;
   $pcb_colors[70]=15;

/*****************************************************************************/
/* STRIP UNWANTED PCBOARD CODES (DEFINED IN CONFIG FILE)                     */
/*****************************************************************************/

   $pcboard_strip_codes_exploded=explode(",",PCBOARD_STRIP_CODES);

   for ($loop=0;$loop<sizeof($pcboard_strip_codes_exploded);$loop++)
   {
      $input_file_buffer=ereg_replace($pcboard_strip_codes_exploded[$loop],"",$input_file_buffer);
   }



/*****************************************************************************/
/* PROCESS PCB                                                               */
/*****************************************************************************/

   $color_background=0;
   $color_foreground=7;

   $loop=0;

   $position_x=0;
   $position_y=0;

   $position_x_max=0;
   $position_y_max=0;

   while ($loop<$input_file_size)
   {
      $current_character=ord($input_file_buffer[$loop]);
      $next_character=ord($input_file_buffer[$loop+1]);

      if ($position_x==80)
      {
         $position_y++;
         $position_x=0;
      }

/*****************************************************************************/
/* CR+LF                                                                     */
/*****************************************************************************/

      if ($current_character==13)
      {
         if ($next_character==10)
         {
            $position_y++;
            $position_x=0;
            $loop++;
         }
      }

/*****************************************************************************/
/* LF                                                                        */
/*****************************************************************************/

      if ($current_character==10)
      {
         $position_y++;
         $position_x=0;
      }

/*****************************************************************************/
/* TAB                                                                       */
/*****************************************************************************/

      if ($current_character==9)
      {
         $position_x+=8;
      }

/*****************************************************************************/
/* SUB                                                                       */
/*****************************************************************************/

      if ($current_character==26)
      {
         break;
      }



/*****************************************************************************/
/* PCB SEQUENCE                                                              */
/*****************************************************************************/

      if ($current_character==64)
      {
         if ($next_character==88)
         {

/*****************************************************************************/
/* SET GRAPHIC RENDITION                                                     */
/*****************************************************************************/

            $color_background=$pcb_colors[ord($input_file_buffer[$loop+2])];
            $color_foreground=$pcb_colors[ord($input_file_buffer[$loop+3])];

            $loop+=3;
         }

/*****************************************************************************/
/* ERASE DISPLAY                                                             */
/*****************************************************************************/

         if ($next_character==67 & ord($input_file_buffer[$loop+2])==76 & ord($input_file_buffer[$loop+3])==83)
         {
            unset($pcboard_buffer);

            $position_x=0;
            $position_y=0;

            $position_x_max=0;
            $position_y_max=0;

            $loop+=4;
         }

/*****************************************************************************/
/* CURSOR POSITION                                                           */
/*****************************************************************************/

         if ($next_character==80 & ord($input_file_buffer[$loop+2])==79 & ord($input_file_buffer[$loop+3])==83 & ord($input_file_buffer[$loop+4])==58)
         {
            if (ord($input_file_buffer[$loop+6])==64)
            {
               $position_x=(ord($input_file_buffer[$loop+5])-48)-1;
               $loop+=5;
            }
            else
            {
               $position_x=(10*(ord($input_file_buffer[$loop+5])-48)+ord($input_file_buffer[$loop+6])-48)-1;
               $loop+=6;
            }
         }
      }
      elseif ($current_character!=10 && $current_character!=13 && $current_character!=9)
      {

/*****************************************************************************/
/* RECORD NUMBER OF COLUMNS AND LINES USED                                   */
/*****************************************************************************/

         if ($position_x>$position_x_max)
         {
            $position_x_max=$position_x;
         }

         if ($position_y>$position_y_max)
         {
            $position_y_max=$position_y;
         }



/*****************************************************************************/
/* WRITE CURRENT CHARACTER INFO IN A TEMPORARY ARRAY                         */
/*****************************************************************************/

         $pcboard_buffer[]=$position_x;
         $pcboard_buffer[]=$position_y;
         $pcboard_buffer[]=$color_background;
         $pcboard_buffer[]=$color_foreground;
         $pcboard_buffer[]=$current_character;

         $position_x++;
      }
      $loop++;
   }



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   $position_x_max++;
   $position_y_max++;

   if (!$pcboard = imagecreate($columns*$bits,($position_y_max)*$font_size_y))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   imagecolorallocate($pcboard,0,0,0);



/*****************************************************************************/
/* RENDER PCB                                                                */
/*****************************************************************************/

   for ($loop=0;$loop<sizeof($pcboard_buffer);$loop+=5)
   {
      $position_x=$pcboard_buffer[$loop];
      $position_y=$pcboard_buffer[$loop+1];
      $color_background=$pcboard_buffer[$loop+2];
      $color_foreground=$pcboard_buffer[$loop+3];
      $character=$pcboard_buffer[$loop+4];

      imagecopy($pcboard,$background,$position_x*$bits,$position_y*$font_size_y,$color_background*9,0,$bits,$font_size_y);
      imagecopy($pcboard,$font,$position_x*$bits,$position_y*$font_size_y,$character*$font_size_x,$color_foreground*$font_size_y,$bits,$font_size_y);
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$pcboard,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($pcboard);
      }
      else
      {
         ImagePNG($pcboard,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($pcboard);
   imagedestroy($background);
   imagedestroy($font);
}



/*****************************************************************************/
/* LOAD BINARY                                                               */
/*****************************************************************************/

function load_binary($input,$output,$columns,$font,$bits,$icecolors)
{
   check_libraries();

/*****************************************************************************/
/* CHECK PARAMETERS AND FORCE DEFAULT VALUES IF INVALID INPUT IS DETECTED    */
/*****************************************************************************/

   if ($columns==0)
   {
      $columns=160;
   }

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }
   if ($bits!=8 && $bits!=9)
   {
      $bits=8;
   }

   switch($font)
   {
   case '80x25':
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case '80x50':
      $font_file='ansilove_font_pc_80x50.png';
      $font_size_x=9;
      $font_size_y=8;
      break;

   case 'armenian':
      $font_file='ansilove_font_pc_armenian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'baltic':
      $font_file='ansilove_font_pc_baltic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'cyrillic':
      $font_file='ansilove_font_pc_cyrillic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'french-canadian':
      $font_file='ansilove_font_pc_french_canadian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek':
      $font_file='ansilove_font_pc_greek.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek-869':
      $font_file='ansilove_font_pc_greek_869.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'hebrew':
      $font_file='ansilove_font_pc_hebrew.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'icelandic':
      $font_file='ansilove_font_pc_icelandic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin1':
      $font_file='ansilove_font_pc_latin1.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin2':
      $font_file='ansilove_font_pc_latin2.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'nordic':
      $font_file='ansilove_font_pc_nordic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'persian':
      $font_file='ansilove_font_pc_persian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'portuguese':
      $font_file='ansilove_font_pc_portuguese.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'russian':
      $font_file='ansilove_font_pc_russian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'turkish':
      $font_file='ansilove_font_pc_turkish.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'amiga':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'b-strict':
      $font_file='ansilove_font_b-strict.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'b-struct':
      $font_file='ansilove_font_b-struct.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'microknight':
      $font_file='ansilove_font_microknight.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'mosoul':
      $font_file='ansilove_font_mosoul.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'pot-noodle':
      $font_file='ansilove_font_pot-noodle.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz':
      $font_file='ansilove_font_topaz.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz+':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topazplus':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   default:
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
   }



/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* LOAD BACKGROUND/FONT AND ALLOCATE IMAGE BUFFER MEMORY                     */
/*****************************************************************************/

   if (!$background = imagecreatefrompng(dirname(__FILE__).'/fonts/ansilove_background.png'))
   {
      echo "ERROR: Can't open file ansilove_background.png\n\n";
      exit(-1);
   }

   if (!$font = imagecreatefrompng(dirname(__FILE__).'/fonts/'.$font_file))
   {
      echo "ERROR: Can't open file $font_file\n\n";
      exit(-1);
   }

   imagecolortransparent($font,20);

   if (!$binary = imagecreate($columns*$bits,(($input_file_size/2)/$columns)*$font_size_y))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   imagecolorallocate($binary,0,0,0);



/*****************************************************************************/
/* PROCESS BINARY                                                            */
/*****************************************************************************/

   while ($loop<$input_file_size)
   {
      if ($position_x==$columns)
      {
         $position_x=0;
         $position_y++;
      }

      $character=ord($input_file_buffer[$loop]);
      $attribute=ord($input_file_buffer[$loop+1]);

      $color_background=($attribute & 240)>>4;
      $color_foreground=$attribute & 15;

      if ($color_background>8 && $icecolors==0)
      {
         $color_background-=8;
      }

      imagecopy($binary,$background,$position_x*$bits,$position_y*$font_size_y,$color_background*9,0,$bits,$font_size_y);
      imagecopy($binary,$font,$position_x*$bits,$position_y*$font_size_y,$character*$font_size_x,$color_foreground*$font_size_y,$bits,$font_size_y);

      $position_x++;
      $loop+=2;
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      $position_y_max=($input_file_size/2)/$columns;
      
      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$binary,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($binary);
      }
      else
      {
         ImagePNG($binary,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($binary);
   imagedestroy($background);
   imagedestroy($font);
}



/*****************************************************************************/
/* LOAD ADF                                                                  */
/*****************************************************************************/

function load_adf($input,$output,$bits)
{
   check_libraries();

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }

/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* ALLOCATE BACKGROUND/FONT IMAGE BUFFER MEMORY                              */
/*****************************************************************************/

   if (!$background = imagecreate(128,16))
   {
      echo "ERROR: Can't allocate background buffer image memory\n\n";
      exit(-1);
   }

   if (!$font = imagecreate(2048,256))
   {
      echo "ERROR: Can't allocate font buffer image memory\n\n";
      exit(-1);
   }

   if (!$font_inverted = imagecreate(2048,16))
   {
      echo "ERROR: Can't allocate temporary font buffer image memory\n\n";
      exit(-1);
   }



/*****************************************************************************/
/* PROCESS ADF PALETTE                                                       */
/*****************************************************************************/

   $adf_colors=array(0,1,2,3,4,5,20,7,56,57,58,59,60,61,62,63);

   for ($loop=0;$loop<16;$loop++)
   {
      $index=($adf_colors[$loop]*3)+1;
      $colors[$loop]=imagecolorallocate($background,(ord($input_file_buffer[$index])<<2 | ord($input_file_buffer[$index])>>4),(ord($input_file_buffer[$index+1])<<2 | ord($input_file_buffer[$index+1])>>4),(ord($input_file_buffer[$index+2])<<2 | ord($input_file_buffer[$index+2])>>4));
   }

   imagepalettecopy($font,$background);
   imagepalettecopy($font_inverted,$background);

   $color_index=imagecolorsforindex($background, 0);
   $colors[16]=imagecolorallocate($font,$color_index['red'],$color_index['green'],$color_index['blue']);
   $colors[20]=imagecolorallocate($font_inverted,200,220,169);

   for ($loop=0;$loop<16;$loop++)
   {
      imagefilledrectangle($background,$loop<<3,0,($loop<<3)+8,16,$colors[$loop]);
   }



/*****************************************************************************/
/* PROCESS ADF FONT                                                          */
/*****************************************************************************/

   imagefilledrectangle($font_inverted,0,0,2048,16,$colors[20]);
   imagecolortransparent($font_inverted,$colors[20]);

   for ($loop=0;$loop<256;$loop++)
   {
      for ($adf_font_size_y=0;$adf_font_size_y<16;$adf_font_size_y++)
      {
         $adf_character_line=ord($input_file_buffer[193+$adf_font_size_y+($loop*16)]);

         for ($loop_column=0;$loop_column<8;$loop_column++)
         {
            $adf_character_column=128/pow(2,$loop_column);

            if (($adf_character_line & $adf_character_column)!=$adf_character_column)
            {
               imagesetpixel($font_inverted,($loop*8)+$loop_column,$adf_font_size_y,$colors[0]);
            }
         }
      }
   }

   for ($loop=1;$loop<16;$loop++)
   {
      imagefilledrectangle($font,0,$loop*16,2048,($loop*16)+16,$colors[$loop]);
   }
   imagefilledrectangle($font,0,0,2048,15,$colors[16]);

   for ($loop=0;$loop<16;$loop++)
   {
      imagecopy($font,$font_inverted,0,$loop*16,0,0,2048,16);
   }
   imagecolortransparent($font,$colors[0]);



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   if (!$adf = imagecreate(640,((($input_file_size-192-4096-1)/2)/80)*16))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   imagecolorallocate($adf,0,0,0);



/*****************************************************************************/
/* PROCESS ADF                                                               */
/*****************************************************************************/

   $loop=192+4096+1;

   while ($loop<$input_file_size)
   {
      if ($position_x==80)
      {
         $position_x=0;
         $position_y++;
      }

      $character=ord($input_file_buffer[$loop]);
      $attribute=ord($input_file_buffer[$loop+1]);

      $color_background=($attribute & 240)>>4;
      $color_foreground=$attribute & 15;

      imagecopy($adf,$background,$position_x*8,$position_y*16,$color_background*8,0,8,16);
      imagecopy($adf,$font,$position_x*8,$position_y*16,$character*8,$color_foreground*16,8,16);

      $position_x++;
      $loop+=2;
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      $position_y_max=(($input_file_size-192-4096-1)/2)/80;
      $font_size_y=16;

      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$adf,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($adf);
      }
      else
      {
         ImagePNG($adf,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($adf);
   imagedestroy($background);
   imagedestroy($font);
   imagedestroy($font_inverted);
}



/*****************************************************************************/
/* LOAD IDF                                                                  */
/*****************************************************************************/

function load_idf($input,$output,$bits)
{
   check_libraries();

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }

/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* EXTRACT IDF HEADER                                                        */
/*****************************************************************************/

   $idf_header['ID']=substr($input_file_buffer,0,4);
   $idf_header=array_merge($idf_header,unpack('vx1/vy1/vx2/vy2',substr($input_file_buffer,4,8)));



/*****************************************************************************/
/* ALLOCATE BACKGROUND/FONT IMAGE BUFFER MEMORY                              */
/*****************************************************************************/

   if (!$background = imagecreate(128,16))
   {
      echo "ERROR: Can't allocate background buffer image memory\n\n";
      exit(-1);
   }

   if (!$font = imagecreate(2048,256))
   {
      echo "ERROR: Can't allocate font buffer image memory\n\n";
      exit(-1);
   }

   if (!$font_inverted = imagecreate(2048,16))
   {
      echo "ERROR: Can't allocate temporary font buffer image memory\n\n";
      exit(-1);
   }



/*****************************************************************************/
/* PROCESS IDF PALETTE                                                       */
/*****************************************************************************/

   for ($loop=0;$loop<16;$loop++)
   {
      $index=($loop*3)+$input_file_size-48;
      $colors[$loop]=imagecolorallocate($background,(ord($input_file_buffer[$index])<<2 | ord($input_file_buffer[$index])>>4),(ord($input_file_buffer[$index+1])<<2 | ord($input_file_buffer[$index+1])>>4),(ord($input_file_buffer[$index+2])<<2 | ord($input_file_buffer[$index+2])>>4));
   }

   imagepalettecopy($font,$background);
   imagepalettecopy($font_inverted,$background);

   $color_index=imagecolorsforindex($background,0);
   $colors[16]=imagecolorallocate($font,$color_index['red'],$color_index['green'],$color_index['blue']);
   $colors[20]= imagecolorallocate($font_inverted,200,220,169);

   for ($loop=0;$loop<16;$loop++)
   {
      imagefilledrectangle($background,$loop<<3,0,($loop<<3)+8,16,$colors[$loop]);
   }



/*****************************************************************************/
/* PROCESS IDF FONT                                                          */
/*****************************************************************************/

   imagefilledrectangle($font_inverted,0,0,2048,16,$colors[20]);
   imagecolortransparent($font_inverted,$colors[20]);

   for ($loop=0;$loop<256;$loop++)
   {
      for ($idf_font_size_y=0;$idf_font_size_y<16;$idf_font_size_y++)
      {
         $idf_character_line=ord($input_file_buffer[$input_file_size-48-4096+$idf_font_size_y+($loop*16)]);

         for ($loop_column=0;$loop_column<8;$loop_column++)
         {
            $idf_character_column=128/pow(2,$loop_column);

            if (($idf_character_line & $idf_character_column)!=$idf_character_column)
            {
               imagesetpixel($font_inverted,($loop*8)+$loop_column,$idf_font_size_y,$colors[0]);
            }
         }
      }
   }

   for ($loop=1;$loop<16;$loop++)
   {
      imagefilledrectangle($font,0,$loop*16,2048,($loop*16)+16,$colors[$loop]);
   }
   imagefilledrectangle($font,0,0,2048,15,$colors[16]);

   for ($loop=0;$loop<16;$loop++)
   {
      imagecopy($font,$font_inverted,0,$loop*16,0,0,2048,16);
   }
   imagecolortransparent($font,$colors[0]);



/*****************************************************************************/
/* PROCESS IDF                                                               */
/*****************************************************************************/

   $loop=12;

   while ($loop<$input_file_size-4096-48)
   {
      $idf_data=unpack('vdata',substr($input_file_buffer,$loop,2));
      if ($idf_data['data']==1)
      {
         $idf_data=unpack('vlength',substr($input_file_buffer,$loop+2,2));

         $idf_sequence_length=$idf_data['length'] & 255;
         $idf_data=unpack('Ccharacter/Cattribute',substr($input_file_buffer,$loop+4,2));

         for ($idf_sequence_loop=0;$idf_sequence_loop<$idf_sequence_length;$idf_sequence_loop++)
         {
            $idf_buffer[]=$idf_data['character'];
            $idf_buffer[]=$idf_data['attribute'];
         }

         $loop+=4;
      }
      else
      {
         $idf_data=unpack('Ccharacter/Cattribute',substr($input_file_buffer,$loop,2));

         $idf_buffer[]=$idf_data['character'];
         $idf_buffer[]=$idf_data['attribute'];
      }

      $loop+=2;
   }



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   if (!$idf = imagecreate(($idf_header['x2']+1)*8,(sizeof($idf_buffer)/2/80)*16))
   {
      echo "ERROR: Can't allocate buffer image memoryeee\n\n";
      exit(-1);
   }

   imagecolorallocate($idf,0,0,0);



/*****************************************************************************/
/* RENDER IDF                                                                */
/*****************************************************************************/

   for ($loop=0;$loop<sizeof($idf_buffer);$loop+=2)
   {
      if ($position_x==$idf_header['x2']+1)
      {
         $position_x=0;
         $position_y++;
      }

      $character=$idf_buffer[$loop];
      $attribute=$idf_buffer[$loop+1];

      $color_background=($attribute & 240)>>4;
      $color_foreground=$attribute & 15;

      imagecopy($idf,$background,$position_x*8,$position_y*16,$color_background*8,0,8,16);
      imagecopy($idf,$font,$position_x*8,$position_y*16,$character*8,$color_foreground*16,8,16);

      $position_x++;
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      $position_y_max=$position_y;
      $font_size_y=16;

      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$idf,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($idf);
      }
      else
      {
         ImagePNG($idf,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($idf);
   imagedestroy($background);
   imagedestroy($font);
   imagedestroy($font_inverted);
}



/*****************************************************************************/
/* LOAD TUNDRA                                                               */
/*****************************************************************************/

function load_tundra($input,$output,$font,$bits)
{
   check_libraries();

/*****************************************************************************/
/* CHECK PARAMETERS AND FORCE DEFAULT VALUES IF INVALID INPUT IS DETECTED    */
/*****************************************************************************/

   $columns=80;

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }
   if ($bits!=8 && $bits!=9)
   {
      $bits=8;
   }

   switch($font)
   {
   case '80x25':
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case '80x50':
      $font_file='ansilove_font_pc_80x50.png';
      $font_size_x=9;
      $font_size_y=8;
      break;

   case 'armenian':
      $font_file='ansilove_font_pc_armenian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'baltic':
      $font_file='ansilove_font_pc_baltic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'cyrillic':
      $font_file='ansilove_font_pc_cyrillic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'french-canadian':
      $font_file='ansilove_font_pc_french_canadian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek':
      $font_file='ansilove_font_pc_greek.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'greek-869':
      $font_file='ansilove_font_pc_greek_869.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'hebrew':
      $font_file='ansilove_font_pc_hebrew.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'icelandic':
      $font_file='ansilove_font_pc_icelandic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin1':
      $font_file='ansilove_font_pc_latin1.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'latin2':
      $font_file='ansilove_font_pc_latin2.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'nordic':
      $font_file='ansilove_font_pc_nordic.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'persian':
      $font_file='ansilove_font_pc_persian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'portuguese':
      $font_file='ansilove_font_pc_portuguese.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'russian':
      $font_file='ansilove_font_pc_russian.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'turkish':
      $font_file='ansilove_font_pc_turkish.png';
      $font_size_x=9;
      $font_size_y=16;
      break;

   case 'amiga':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'b-strict':
      $font_file='ansilove_font_b-strict.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'b-struct':
      $font_file='ansilove_font_b-struct.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'microknight':
      $font_file='ansilove_font_microknight.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'mosoul':
      $font_file='ansilove_font_mosoul.png';
      $font_size_x=8;
      $font_size_y=8;
      $bits=8;
      break;

   case 'pot-noodle':
      $font_file='ansilove_font_pot-noodle.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz':
      $font_file='ansilove_font_topaz.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topaz+':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   case 'topazplus':
      $font_file='ansilove_font_topaz+.png';
      $font_size_x=8;
      $font_size_y=11;
      $bits=8;
      break;

   default:
      $font_file='ansilove_font_pc_80x25.png';
      $font_size_x=9;
      $font_size_y=16;
   }



/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* EXTRACT TUNDRA HEADER                                                     */
/*****************************************************************************/

   $tundra_header['value']=$input_file_buffer[0];
   $tundra_header['string']=substr($input_file_buffer,1,8);

   if (ord($tundra_header['value'])!=24 || $tundra_header['string']!='TUNDRA24')
   {
      echo "ERROR: $input is not a TUNDRA file.\n\n";
      exit;
   }



/*****************************************************************************/
/* LOAD BACKGROUND/FONT AND ALLOCATE IMAGE BUFFER MEMORY                     */
/*****************************************************************************/

   if (!$background = imagecreatefrompng(dirname(__FILE__).'/fonts/ansilove_background.png'))
   {
      echo "ERROR: Can't open file ansilove_background.png\n\n";
      exit(-1);
   }

   if (!$font = imagecreatefrompng(dirname(__FILE__).'/fonts/'.$font_file))
   {
      echo "ERROR: Can't open file $font_file\n\n";
      exit(-1);
   }

   imagecolorset($font,20,0,0,0);



/*****************************************************************************/
/* READ TUNDRA FILE A FIRST TIME TO FIND THE IMAGE SIZE                      */
/*****************************************************************************/

   $loop=9;

   while ($loop<$input_file_size)
   {
      if ($position_x==80)
      {
         $position_x=0;
         $position_y++;
      }

      $character=ord($input_file_buffer[$loop]);

      if ($character==1)
      {
         $tundra_position_array=unpack('Nposition_y/Nposition_x',substr($input_file_buffer,$loop+1,8));
         $position_y=$tundra_position_array['position_y'];
         $position_x=$tundra_position_array['position_x'];

         $loop+=8;
      }

      if ($character==2)
      {
         $loop+=5;
      }

      if ($character==4)
      {
         $loop+=5;
      }

      if ($character==6)
      {
         $loop+=9;
      }

      if ($character!=1 && $character!=2 && $character!=4 && $character!=6)
      {
         $position_x++;
      }

      $loop++;
   }

   $position_y++;



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   if (!$tundra = imagecreate($columns*$bits,($position_y)*$font_size_y))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   imagecolorallocate($tundra,0,0,0);



/*****************************************************************************/
/* PROCESS TUNDRA FILE                                                       */
/*****************************************************************************/

   $position_x=0;
   $position_y=0;

   $loop=9;

   while ($loop<$input_file_size)
   {
      if ($position_x==$columns)
      {
         $position_x=0;
         $position_y++;
      }

      $character=ord($input_file_buffer[$loop]);

      if ($character==1)
      {
         $tundra_position_array=unpack('Nposition_y/Nposition_x',substr($input_file_buffer,$loop+1,8));
         $position_y=$tundra_position_array['position_y'];
         $position_x=$tundra_position_array['position_x'];

         $loop+=8;
      }

      if ($character==2)
      {
         $tundra_color_array=unpack('Ncolor_foreground',substr($input_file_buffer,$loop+2,4));
         $color_foreground=$tundra_color_array['color_foreground'];
         $red=($color_foreground>>16) & 0x000000FF;
         $green=($color_foreground>>8) & 0x000000FF;
         $blue=$color_foreground & 0x000000FF;
         imagecolorset($font,0,$red,$green,$blue);

         $character=ord($input_file_buffer[$loop+1]);

         $loop+=5;
      }


      if ($character==4)
      {
         $tundra_color_array=unpack('Ncolor_background',substr($input_file_buffer,$loop+2,4));
         $color_background=$tundra_color_array['color_background'];
         $red=($color_background>>16) & 0x000000FF;
         $green=($color_background>>8) & 0x000000FF;
         $blue=$color_background & 0x000000FF;
         imagecolorset($font,20,$red,$green,$blue);

         $character=ord($input_file_buffer[$loop+1]);

         $loop+=5;
      }

      if ($character==6)
      {
         $tundra_color_array=unpack('Ncolor_foreground/Ncolor_background',substr($input_file_buffer,$loop+2,8));
         $color_foreground=$tundra_color_array['color_foreground'];
         $red=($color_foreground>>16) & 0x000000FF;
         $green=($color_foreground>>8) & 0x000000FF;
         $blue=$color_foreground & 0x000000FF;
         imagecolorset($font,0,$red,$green,$blue);

         $color_background=$tundra_color_array['color_background'];
         $red=($color_background>>16) & 0x000000FF;
         $green=($color_background>>8) & 0x000000FF;
         $blue=$color_background & 0x000000FF;
         imagecolorset($font,20,$red,$green,$blue);

         $character=ord($input_file_buffer[$loop+1]);

         $loop+=9;
      }

      if ($character!=1 && $character!=2 && $character!=4 && $character!=6)
      {
         imagecopy($tundra,$font,$position_x*$bits,$position_y*$font_size_y,$character*$font_size_x,0,$bits,$font_size_y);

         $position_x++;
      }

      $loop++;
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      $position_y_max=$position_y;

      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$tundra,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($tundra);
      }
      else
      {
         ImagePNG($tundra,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($tundra);
   imagedestroy($background);
   imagedestroy($font);
}



/*****************************************************************************/
/* LOAD XBIN                                                                 */
/*****************************************************************************/

function load_xbin($input,$output,$bits)
{
   check_libraries();

   if ($bits=='thumbnail')
   {
      $thumbnail=1;
   }

/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_sauce=load_sauce($input);

   if ($input_file_sauce!=NULL)
   {
      $input_file_size=$input_file_sauce['FileSize'];
   }
   else
   {
      $input_file_size=filesize($input);
   }

   if (!$input_file_buffer = fread($input_file,$input_file_size))
   {
      echo "ERROR: Can't read file $input\n\n";
      exit(-1);
   }

   fclose($input_file);



/*****************************************************************************/
/* EXTRACT XBIN HEADER                                                       */
/*****************************************************************************/

   $xbin_header['ID']=substr($input_file_buffer,0,4);

   if ($xbin_header['ID']!='XBIN')
   {
      echo "ERROR: $input is not a XBiN file.\n\n";
      exit;
   }

   $xbin_header=array_merge($xbin_header,unpack('CEofChar/vWidth/vHeight/CFontsize/CFlags',substr($input_file_buffer,4,7)));

   if (($xbin_header['Flags'] & 1)==1)
   {
      $xbin_flags['palette']=1;
   }

   if (($xbin_header['Flags'] & 2)==2)
   {
      $xbin_flags['font']=1;
   }

   if (($xbin_header['Flags'] & 4)==4)
   {
      $xbin_flags['compress']=1;
   }

   if (($xbin_header['Flags'] & 8)==8)
   {
      $xbin_flags['nonblink']=1;
   }

   if (($xbin_header['Flags'] & 16)==16)
   {
      $xbin_flags['512chars']=1;
   }



/*****************************************************************************/
/* PROCESS XBIN PALETTE                                                      */
/*****************************************************************************/

   if ($xbin_flags['palette']==1)
   {
      if (!$background = imagecreate(128,16))
      {
         echo "ERROR: Can't allocate background buffer image memory\n\n";
         exit(-1);
      }

      for ($loop=0;$loop<16;$loop++)
      {
         $index=($loop*3)+11;
         $colors[$loop]=imagecolorallocate($background,(ord($input_file_buffer[$index])<<2 | ord($input_file_buffer[$index])>>4),(ord($input_file_buffer[$index+1])<<2 | ord($input_file_buffer[$index+1])>>4),(ord($input_file_buffer[$index+2])<<2 | ord($input_file_buffer[$index+2])>>4));
      }

      for ($loop=0;$loop<16;$loop++)
      {
         imagefilledrectangle($background,$loop<<3,0,($loop<<3)+8,16,$colors[$loop]);
      }

      $background_size_x=8;
   }
   else
   {
      if (!$background = imagecreatefrompng(dirname(__FILE__).'/fonts/ansilove_background.png'))
      {
         echo "ERROR: Can't open file ansilove_background.png\n\n";
         exit(-1);
      }

      $background_size_x=9;
   }



/*****************************************************************************/
/* PROCESS XBIN FONT                                                         */
/*****************************************************************************/

   if ($xbin_flags['font']==1)
   {
      if (!$font = imagecreate(2048,$xbin_header['Fontsize']*16))
      {
         echo "ERROR: Can't allocate font buffer image memory\n\n";
         exit(-1);
      }

      if (!$font_inverted = imagecreate(2048,$xbin_header['Fontsize']))
      {
         echo "ERROR: Can't allocate temporary font buffer image memory\n\n";
         exit(-1);
      }

      imagepalettecopy($font,$background);
      imagepalettecopy($font_inverted,$background);

      $color_index=imagecolorsforindex($background,0);
      $colors[16]=imagecolorallocate($font,$color_index['red'],$color_index['green'],$color_index['blue']);
      $colors[20]=imagecolorallocate($font_inverted,200,220,169);

      imagefilledrectangle($font_inverted,0,0,2048,$xbin_header['Fontsize'],$colors[20]);
      imagecolortransparent($font_inverted,$colors[20]);

      for ($loop=0;$loop<256;$loop++)
      {
         for ($xbin_font_size_y=0;$xbin_font_size_y<$xbin_header['Fontsize'];$xbin_font_size_y++)
         {
            $xbin_character_line=ord($input_file_buffer[11+$xbin_flags['palette']*48+$xbin_font_size_y+($loop*$xbin_header['Fontsize'])]);

            for ($loop_column=0;$loop_column<8;$loop_column++)
            {
               $xbin_character_column=128/pow(2,$loop_column);

               if (($xbin_character_line & $xbin_character_column)!=$xbin_character_column)
               {
                  imagesetpixel($font_inverted,($loop*8)+$loop_column,$xbin_font_size_y,$colors[0]);
               }
            }
         }
      }

      for ($loop=1;$loop<16;$loop++)
      {
         imagefilledrectangle($font,0,$loop*$xbin_header['Fontsize'],2048,($loop*$xbin_header['Fontsize'])+$xbin_header['Fontsize'],$loop);
      }
      imagefilledrectangle($font,0,0,2048,$xbin_header['Fontsize']-1,$colors[16]);

      for ($loop=0;$loop<16;$loop++)
      {
         imagecopy ($font, $font_inverted, 0,$loop*$xbin_header['Fontsize'],0,0,2048,$xbin_header['Fontsize']);
      }
      imagecolortransparent($font,$colors[0]);

      $font_size_x=8;
      $font_size_y=$xbin_header['Fontsize'];
   }
   else
   {
      if (!$font = imagecreatefrompng (dirname(__FILE__).'/fonts/ansilove_font_pc_80x25.png'))
      {
         echo "ERROR: Can't open file $font_file\n\n";
         exit(-1);
      }

      $font_size_x=9;
      $font_size_y=16;

      imagecolortransparent($font,20);
   }



/*****************************************************************************/
/* PROCESS XBIN                                                              */
/*****************************************************************************/

   $loop=11+$xbin_flags['palette']*48+$xbin_flags['font']*256*$xbin_header['Fontsize'];

   if ($xbin_flags['compress']==1)
   {
      while ($loop<$input_file_size)
      {
         $character=ord($input_file_buffer[$loop]);

         $compression=$character & 192;
         $repeat=1+($character & 63);

         if ($compression==0)
         {
            for ($i=0;$i<$repeat*2;$i++)
            {
               $xbin_buffer[]=ord($input_file_buffer[$loop+1+$i]);
            }

            $loop=$loop+1+($repeat*2);
         }

         if ($compression==64)
         {
            for ($i=0;$i<$repeat;$i++)
            {
               $xbin_buffer[]=ord($input_file_buffer[$loop+1]);
               $xbin_buffer[]=ord($input_file_buffer[$loop+2+$i]);
            }

            $loop=$loop+2+$repeat;
         }

         if ($compression==128)
         {
            for ($i=0;$i<$repeat;$i++)
            {
               $xbin_buffer[]=ord($input_file_buffer[$loop+2+$i]);
               $xbin_buffer[]=ord($input_file_buffer[$loop+1]);
            }

            $loop=$loop+2+$repeat;
         }

         if ($compression==192)
         {
            for ($i=0;$i<$repeat;$i++)
            {
               $xbin_buffer[]=ord($input_file_buffer[$loop+1]);
               $xbin_buffer[]=ord($input_file_buffer[$loop+2]);
            }

            $loop+=3;
         }
      }
   }
   else
   {
      while ($loop<$input_file_size)
      {
         $xbin_buffer[]=ord($input_file_buffer[$loop]);
         $loop++;
      }
   }



/*****************************************************************************/
/* ALLOCATE IMAGE BUFFER MEMORY                                              */
/*****************************************************************************/

   if (!$xbin = imagecreatetruecolor($xbin_header['Width']*8,$xbin_header['Height']*$font_size_y))
   {
      echo "ERROR: Can't allocate buffer image memory\n\n";
      exit(-1);
   }

   imagecolorallocate($xbin,0,0,0);



/*****************************************************************************/
/* RENDER XBIN                                                               */
/*****************************************************************************/

   for ($loop=0;$loop<sizeof($xbin_buffer);$loop+=2)
   {
      if ($position_x==$xbin_header['Width'])
      {
         $position_x=0;
         $position_y++;
      }

      $character=($xbin_buffer[$loop]);
      $attribute=($xbin_buffer[$loop+1]);

      $color_background=($attribute & 240)>>4;
      $color_foreground=$attribute & 15;

      imagecopy($xbin, $background,$position_x*8,$position_y*$font_size_y,$color_background*$background_size_x,0,8,$font_size_y);
      imagecopy($xbin,$font,$position_x*8,$position_y*$font_size_y,$character*$font_size_x,$color_foreground*$font_size_y,8,$font_size_y);

      $position_x++;
   }



/*****************************************************************************/
/* CREATE OUTPUT FILE                                                        */
/*****************************************************************************/

   if ($thumbnail==1)
   {
      $position_y_max=$xbin_header['Height'];

      if (THUMBNAILS_HEIGHT==0)
      {
         $height=$position_y_max*($font_size_y/8);
         $height_source=$position_y_max*$font_size_y;
      }
      else
      {
         $height=min($position_y_max*($font_size_y/8),THUMBNAILS_HEIGHT);
         $height_source=$height*8;
      }

      $columns=80;

      if (!$thumbnail = imagecreatetruecolor($columns,$height))
      {
         echo "ERROR: Can't allocate buffer image memory\n\n";
         exit(-1);
      }

      imagecopyresampled($thumbnail,$xbin,0,0,0,0,$columns,$height,$columns*8,$height_source);

      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($thumbnail);
      }
      else
      {
         ImagePNG($thumbnail,$output);
      }

      imagedestroy($thumbnail);
   }
   else
   {
      if ($output=='online')
      {
         Header("Content-type: image/png");
         ImagePNG($xbin);
      }
      else
      {
         ImagePNG($xbin,$output);
      }
   }



/*****************************************************************************/
/* FREE MEMORY                                                               */
/*****************************************************************************/

   imagedestroy($xbin);
   imagedestroy($background);
   imagedestroy($font);

   if ($xbin_flags['font']==1)
   {
      imagedestroy($font_inverted);
   }
}



/*****************************************************************************/
/* LOAD SAUCE                                                                */
/*****************************************************************************/

function load_sauce($input)
{

/*****************************************************************************/
/* LOAD INPUT FILE                                                           */
/*****************************************************************************/

   if (!$input_file = fopen ($input,'r'))
   {
      echo "ERROR: Can't open file $input\n\n";
      exit(-1);
   }

   $input_file_size=filesize($input);



/*****************************************************************************/
/* PROCESS SAUCE                                                             */
/*****************************************************************************/

   if ($input_file_size>=128)
   {
      fseek($input_file,$input_file_size-128);
      $input_file_buffer=fread($input_file,128);

      $sauce['ID']=substr($input_file_buffer,0,5);
      $sauce['Version']=substr($input_file_buffer,5,2);
      $sauce['Title']=substr($input_file_buffer,7,35);
      $sauce['Author']=substr($input_file_buffer,42,20);
      $sauce['Group']=substr($input_file_buffer,62,20);
      $sauce['Date']=substr($input_file_buffer,82,8);
      $sauce=array_merge($sauce,unpack('lFileSize/CDataType/CFileType/v4TInfo/CComments/CFlags',substr($input_file_buffer,90,16)));
      $sauce['Filler']=substr($input_file_buffer,106,22);
   }



/*****************************************************************************/
/* PROCESS SAUCE COMMENTS                                                    */
/*****************************************************************************/

   $sauce_comment_lines=$sauce['Comments'];

   if ($sauce_comment_lines!=0)
   {
      if ($input_file_size>=128+5+($sauce_comment_lines*64))
      {
         fseek($input_file,($input_file_size-128-5-($sauce_comment_lines*64)));
         $comment_id=fread($input_file,5);

         if ($comment_id=='COMNT')
         {
            for ($loop=0;$loop<$sauce_comment_lines;$loop++)
            {
               fseek($input_file,($input_file_size-128-($sauce_comment_lines*64)+($loop*64)));

               $comment_line="Comment_Line_";
               if ($loop<9)
               {
                  $comment_line.="0";
               }
               $comment_line.=($loop+1);

               $sauce[$comment_line]=fread($input_file,64);
            }
         }
      }
   }

   fclose($input_file);



/*****************************************************************************/
/* RETURN SAUCE                                                              */
/*****************************************************************************/

   if ($sauce['ID']=='SAUCE')
   {
      return($sauce);
   }
}
?>
