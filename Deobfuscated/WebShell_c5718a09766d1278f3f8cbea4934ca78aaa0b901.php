<?php
// Set language:
$lang = 'auto';

// Charset of output:
$site_charset = 'auto';

// Homedir:
$homedir = './';

// Size of the edit textarea
$editcols = 150;
$editrows = 38;

/* -------------------------------------------
 * Optional configuration (remove # to enable)
 */
 
/* Permission of created directories:
 * For example: 0705 would be 'drwx---r-x'.
 */
# $dirpermission = 0705;

/* Permission of created files:
 * For example: 0604 would be '-rw----r--'. 
 */
# $filepermission = 0604;

// Filenames related to the apache web server:
$htaccess = '.htaccess';
$htpasswd = '.htpasswd';

/* ------------------------------------------------------------------------- */
if (get_magic_quotes_gpc()) {
    array_walk($_GET, 'strip');
    array_walk($_POST, 'strip');
    array_walk($_REQUEST, 'strip');
}

if (array_key_exists('image', $_GET)) {
    header('Content-Type: image/gif');
    die(getimage($_GET['image']));
}

if (!function_exists('lstat')) {
    function lstat ($filename) {
        return stat($filename);
    }
}

$delim = DIRECTORY_SEPARATOR;

if (function_exists('php_uname')) {
    $win = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? true : false;
} else {
    $win = ($delim == '\\') ? true : false;
}

if (!empty($_SERVER['PATH_TRANSLATED'])) {
    $scriptdir = dirname($_SERVER['PATH_TRANSLATED']);
} elseif (!empty($_SERVER['SCRIPT_FILENAME'])) {
    $scriptdir = dirname($_SERVER['SCRIPT_FILENAME']);
} elseif (function_exists('getcwd')) {
    $scriptdir = getcwd();
} else {
    $scriptdir = '.';
}

$homedir = relative2absolute($homedir, $scriptdir);
$dir = (array_key_exists('dir', $_REQUEST)) ? $_REQUEST['dir'] : $homedir;

if (array_key_exists('olddir', $_POST) && !path_is_relative($_POST['olddir'])) {
    $dir = relative2absolute($dir, $_POST['olddir']);
}

$directory = simplify_path(addslash($dir));

$files = array();
$action = '';
if (!empty($_POST['submit_all'])) {
    $action = $_POST['action_all'];
    for ($i = 0; $i < $_POST['num']; $i++) {
        if (array_key_exists("checked$i", $_POST) && $_POST["checked$i"] == 'true') {
            $files[] = $_POST["file$i"];
        }
    }
} elseif (!empty($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    $files[] = relative2absolute($_REQUEST['file'], $directory);
} elseif (!empty($_POST['submit_upload']) && !empty($_FILES['upload']['name'])) {
    $files[] = $_FILES['upload'];
    $action = 'upload';
} elseif (array_key_exists('num', $_POST)) {
    for ($i = 0; $i < $_POST['num']; $i++) {
        if (array_key_exists("submit$i", $_POST)) break;
    }
    if ($i < $_POST['num']) {
        $action = $_POST["action$i"];
        $files[] = $_POST["file$i"];
    }
}
if (empty($action) && (!empty($_POST['submit_create']) || (array_key_exists('focus', $_POST) && $_POST['focus'] == 'create')) && !empty($_POST['create_name'])) {
    $files[] = relative2absolute($_POST['create_name'], $directory);
    switch ($_POST['create_type']) {
    case 'directory':
        $action = 'create_directory';
        break;
    case 'file':
        $action = 'create_file';
    }
}
if (sizeof($files) == 0) $action = ''; else $file = reset($files);

if ($lang == 'auto') {
    if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) && strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) >= 2) {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    } else {
        $lang = 'en';
    }
}

$words = getwords($lang);

if ($site_charset == 'auto') {
    $site_charset = $word_charset;
}

$cols = ($win) ? 4 : 7;

if (!isset($dirpermission)) {
    $dirpermission = (function_exists('umask')) ? (0777 & ~umask()) : 0755;
}
if (!isset($filepermission)) {
    $filepermission = (function_exists('umask')) ? (0666 & ~umask()) : 0644;
}

if (!empty($_SERVER['SCRIPT_NAME'])) {
    $self = html(basename($_SERVER['SCRIPT_NAME']));
} elseif (!empty($_SERVER['PHP_SELF'])) {
    $self = html(basename($_SERVER['PHP_SELF']));
} else {
    $self = '';
}

if (!empty($_SERVER['SERVER_SOFTWARE'])) {
    if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == 'apache') {
        $apache = true;
    } else {
        $apache = false;
    }
} else {
    $apache = true;
}

switch ($action) {
case 'view':
    if (is_script($file)) {
        // highlight_file is a mess!
        ob_start();
        highlight_file($file);
        $src = ereg_replace('<font color="([^"]*)">', '<span style="color: \1">', ob_get_contents());
        $src = str_replace(array('</font>', "\r", "\n"), array('</span>', '', ''), $src);
        ob_end_clean();
        html_header();
        echo '<h2 style="text-align: left; margin-bottom: 0">' . html($file) . '</h2>
<hr />
<table>
<tr>
<td style="text-align: right; vertical-align: top; color: gray; padding-right: 3pt; border-right: 1px solid gray">
<pre style="margin-top: 0"><code>';
        for ($i = 1; $i <= sizeof(file($file)); $i++) echo "$i\n";
        echo '</code></pre>
</td>
<td style="text-align: left; vertical-align: top; padding-left: 3pt">
<pre style="margin-top: 0">' . $src . '</pre>
</td>
</tr>
</table>';
        html_footer();

    } else {
        header('Content-Type: ' . getmimetype($file));
        header('Content-Disposition: filename=' . basename($file));
        readfile($file);
    }
    break;
    
case 'download':
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Type: ' . getmimetype($file));
    header('Content-Disposition: attachment; filename=' . basename($file) . ';');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    break;

case 'upload':
    if($_POST['newName'] != "")
        $file['name'] = $_POST['newName'];
    $dest = relative2absolute($file['name'], $directory);
    if (@file_exists($dest)) {
        listing_page(error('already_exists', $dest));
    } elseif (@move_uploaded_file($file['tmp_name'], $dest)) {
        @chmod($dest, $filepermission);
        listing_page(notice('uploaded', $file['name']));
    } else {
        listing_page(error('not_uploaded', $file['name']));
    }
    break;

case 'create_directory':
    if (@file_exists($file)) {
        listing_page(error('already_exists', $file));
    } else {
        $old = @umask(0777 & ~$dirpermission);
        if (@mkdir($file, $dirpermission)) {
            listing_page(notice('created', $file));
        } else {
            listing_page(error('not_created', $file));
        }
        @umask($old);
    }
    break;

case 'create_file':
    if (@file_exists($file)) {
        listing_page(error('already_exists', $file));
    } else {
        $old = @umask(0777 & ~$filepermission);
        if (@touch($file)) {
            edit($file);
        } else {
            listing_page(error('not_created', $file));
        }
        @umask($old);
    }
    break;

case 'execute':
    chdir(dirname($file));
    $output = array();
    $retval = 0;
    exec('echo "./' . basename($file) . '" | /bin/sh', $output, $retval);
    $error = ($retval == 0) ? false : true;
    if (sizeof($output) == 0) $output = array('<' . $words['no_output'] . '>');
    if ($error) {
        listing_page(error('not_executed', $file, implode("\n", $output)));
    } else {
        listing_page(notice('executed', $file, implode("\n", $output)));
    }
    break;

case 'delete':
    if (!empty($_POST['no'])) {
        listing_page();
    } elseif (!empty($_POST['yes'])) {
        $failure = array();
        $success = array();
        foreach ($files as $file) {
            if (del($file)) {
                $success[] = $file;
            } else {
                $failure[] = $file;
            }
        }
        $message = '';
        if (sizeof($failure) > 0) {
            $message = error('not_deleted', implode("\n", $failure));
        }
        if (sizeof($success) > 0) {
            $message .= notice('deleted', implode("\n", $success));
        }
        listing_page($message);
    } else {
        html_header();
        echo '<form action="' . $self . '" method="post"><table class="dialog"><tr><td class="dialog">';
        request_dump();
        echo "\t<b>" . word('really_delete') . '</b><p>';
        foreach ($files as $file) {
            echo "\t" . html($file) . "<br />\n";
        }
        echo '    </p><hr />
<input type="submit" name="yes" value="' . word('yes') . '" id="green_button" />
<input type="submit" name="no" value="' . word('no') . '" id="red_button" style="margin-left: 50px" />
</td></tr></table></form>';
        html_footer();
    }
    break;

case 'rename':
    if (!empty($_POST['destination'])) {
        $dest = relative2absolute($_POST['destination'], $directory);
        if (!@file_exists($dest) && @rename($file, $dest)) {
            listing_page(notice('renamed', $file, $dest));
        } else {
            listing_page(error('not_renamed', $file, $dest));
        }
    } else {
        $name = basename($file);
        html_header();
        echo '<form action="' . $self . '" method="post"><table class="dialog"><tr>
<td class="dialog">
    <input type="hidden" name="action" value="rename" />
    <input type="hidden" name="file" value="' . html($file) . '" />
    <input type="hidden" name="dir" value="' . html($directory) . '" />
    <b>' . word('rename_file') . '</b>
    <p>' . html($file) . '</p>
    <b>' . substr($file, 0, strlen($file) - strlen($name)) . '</b>
    <input type="text" name="destination" size="' . textfieldsize($name) . '" value="' . html($name) . '" />
    <hr />
    <input type="submit" value="' . word('rename') . '" />
</td></tr></table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
        html_footer();
    }
    break;

case 'move':
    if (!empty($_POST['destination'])) {
        $dest = relative2absolute($_POST['destination'], $directory);
        $failure = array();
        $success = array();
        foreach ($files as $file) {
            $filename = substr($file, strlen($directory));
            $d = $dest . $filename;
            if (!@file_exists($d) && @rename($file, $d)) {
                $success[] = $file;
            } else {
                $failure[] = $file;
            }
        }
        $message = '';
        if (sizeof($failure) > 0) {
            $message = error('not_moved', implode("\n", $failure), $dest);
        }
        if (sizeof($success) > 0) {
            $message .= notice('moved', implode("\n", $success), $dest);
        }
        listing_page($message);
    } else {
        html_header();
        echo '<form action="' . $self . '" method="post"><table class="dialog"><tr><td class="dialog">';
        request_dump();
        echo "\t<b>" . word('move_files') . '</b><p>';
        foreach ($files as $file) {
            echo "\t" . html($file) . "<br />\n";
        }
        echo '    </p><hr />    ' . word('destination') . ':
<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
<input type="submit" value="' . word('move') . '" />
</td></tr></table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
        html_footer();
    }
    break;

case 'copy':
    if (!empty($_POST['destination'])) {
        $dest = relative2absolute($_POST['destination'], $directory);
        if (@is_dir($dest)) {
            $failure = array();
            $success = array();
            foreach ($files as $file) {
                $filename = substr($file, strlen($directory));
                $d = addslash($dest) . $filename;
                if (!@is_dir($file) && !@file_exists($d) && @copy($file, $d)) {
                    $success[] = $file;
                } else {
                    $failure[] = $file;
                }
            }
            $message = '';
            if (sizeof($failure) > 0) {
                $message = error('not_copied', implode("\n", $failure), $dest);
            }
            if (sizeof($success) > 0) {
                $message .= notice('copied', implode("\n", $success), $dest);
            }
            listing_page($message);
        } else {
            if (!@file_exists($dest) && @copy($file, $dest)) {
                listing_page(notice('copied', $file, $dest));
            } else {
                listing_page(error('not_copied', $file, $dest));
            }
        }
    } else {
        html_header();
        echo '<form action="' . $self . '" method="post"><table class="dialog"><tr><td class="dialog">';
        request_dump();
        echo "\n<b>" . word('copy_files') . '</b><p>';
        foreach ($files as $file) {
            echo "\t" . html($file) . "<br />\n";
        }
        echo '    </p><hr />' . word('destination') . ':
<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
<input type="submit" value="' . word('copy') . '" />
</td></tr></table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
        html_footer();
    }
    break;

case 'create_symlink':
    if (!empty($_POST['destination'])) {
        $dest = relative2absolute($_POST['destination'], $directory);
        if (substr($dest, -1, 1) == $delim) $dest .= basename($file);
        if (!empty($_POST['relative'])) $file = absolute2relative(addslash(dirname($dest)), $file);
        if (!@file_exists($dest) && @symlink($file, $dest)) {
            listing_page(notice('symlinked', $file, $dest));
        } else {
            listing_page(error('not_symlinked', $file, $dest));
        }
    } else {
        html_header();
        echo '<form action="' . $self . '" method="post">
<table class="dialog" id="symlink">
<tr>
    <td style="vertical-align: top">' . word('destination') . ': </td>
    <td>
        <b>' . html($file) . '</b><br />
        <input type="checkbox" name="relative" value="yes" id="checkbox_relative" checked="checked" style="margin-top: 1ex" />
        <label for="checkbox_relative">' . word('relative') . '</label>
        <input type="hidden" name="action" value="create_symlink" />
        <input type="hidden" name="file" value="' . html($file) . '" />
        <input type="hidden" name="dir" value="' . html($directory) . '" />
    </td>
</tr>
<tr>
    <td>' . word('symlink') . ': </td>
    <td>
        <input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
        <input type="submit" value="' . word('create_symlink') . '" />
    </td>
</tr>
</table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
        html_footer();
    }
    break;

case 'edit':
    if (!empty($_POST['save'])) {
        $content = str_replace("\r\n", "\n", $_POST['content']);
        if (($f = @fopen($file, 'w')) && @fwrite($f, $content) !== false && @fclose($f)) {
            listing_page(notice('saved', $file));
        } else {
            listing_page(error('not_saved', $file));
        }
    } else {
        if (@is_readable($file) && @is_writable($file)) {
            edit($file);
        } else {
            listing_page(error('not_edited', $file));
        }
    }
    break;

case 'permission':
    if (!empty($_POST['set'])) {
        $mode = 0;
        if (!empty($_POST['ur'])) $mode |= 0400; if (!empty($_POST['uw'])) $mode |= 0200; if (!empty($_POST['ux'])) $mode |= 0100;
        if (!empty($_POST['gr'])) $mode |= 0040; if (!empty($_POST['gw'])) $mode |= 0020; if (!empty($_POST['gx'])) $mode |= 0010;
        if (!empty($_POST['or'])) $mode |= 0004; if (!empty($_POST['ow'])) $mode |= 0002; if (!empty($_POST['ox'])) $mode |= 0001;
        if (@chmod($file, $mode)) {
            listing_page(notice('permission_set', $file, decoct($mode)));
        } else {
            listing_page(error('permission_not_set', $file, decoct($mode)));
        }
    } else {
        html_header();
        $mode = fileperms($file);
        echo '<form action="' . $self . '" method="post">
<table class="dialog">
<tr>
<td class="dialog">
    <p style="margin: 0">' . phrase('permission_for', $file) . '</p>
    <hr />
    <table id="permission">
    <tr>
        <td></td>
        <td style="border-right: 1px solid black">' . word('owner') . '</td>
        <td style="border-right: 1px solid black">' . word('group') . '</td>
        <td>' . word('other') . '</td>
    </tr>
    <tr>
        <td style="text-align: right">' . word('read') . ':</td>
        <td><input type="checkbox" name="ur" value="1"'; if ($mode & 00400) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="gr" value="1"'; if ($mode & 00040) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="or" value="1"'; if ($mode & 00004) echo ' checked="checked"'; echo ' /></td>
    </tr>
    <tr>
        <td style="text-align: right">' . word('write') . ':</td>
        <td><input type="checkbox" name="uw" value="1"'; if ($mode & 00200) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="gw" value="1"'; if ($mode & 00020) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="ow" value="1"'; if ($mode & 00002) echo ' checked="checked"'; echo ' /></td>
    </tr>
    <tr>
        <td style="text-align: right">' . word('execute') . ':</td>
        <td><input type="checkbox" name="ux" value="1"'; if ($mode & 00100) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="gx" value="1"'; if ($mode & 00010) echo ' checked="checked"'; echo ' /></td>
        <td><input type="checkbox" name="ox" value="1"'; if ($mode & 00001) echo ' checked="checked"'; echo ' /></td>
    </tr>
    </table>
    <hr />
    <input type="submit" name="set" value="   ' . word('set') . '   " />
    <input type="hidden" name="action" value="permission" />
    <input type="hidden" name="file" value="' . html($file) . '" />
    <input type="hidden" name="dir" value="' . html($directory) . '" />
</td>
</tr>
</table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
        html_footer();
    }
    break;

default:
    listing_page();
}

/* ------------------------------------------------------------------------- */
function getlist ($directory) {
    global $delim, $win;

    if ($d = @opendir($directory)) {
        while (($filename = @readdir($d)) !== false) {
            $path = $directory . $filename;
            if ($stat = @lstat($path)) {
                $file = array(
                    'filename'    => $filename,
                    'path'        => $path,
                    'is_file'     => @is_file($path),
                    'is_dir'      => @is_dir($path),
                    'is_link'     => @is_link($path),
                    'is_readable' => @is_readable($path),
                    'is_writable' => @is_writable($path),
                    'size'        => $stat['size'],
                    'permission'  => $stat['mode'],
                    'owner'       => $stat['uid'],
                    'group'       => $stat['gid'],
                    'mtime'       => @filemtime($path),
                    'atime'       => @fileatime($path),
                    'ctime'       => @filectime($path)
                );
                if ($file['is_dir']) {
                    $file['is_executable'] = @file_exists($path . $delim . '.');
                } else {
                    if (!$win) {
                        $file['is_executable'] = @is_executable($path);
                    } else {
                        $file['is_executable'] = true;
                    }
                }
                if ($file['is_link']) $file['target'] = @readlink($path);
                if (function_exists('posix_getpwuid')) $file['owner_name'] = @reset(posix_getpwuid($file['owner']));
                if (function_exists('posix_getgrgid')) $file['group_name'] = @reset(posix_getgrgid($file['group']));
                $files[] = $file;
            }

        }
        return $files;
    } else {
        return false;
    }
}

function sortlist ($list, $key, $reverse) {
    $dirs = array();
    $files = array();
    
    for ($i = 0; $i < sizeof($list); $i++) {
        if ($list[$i]['is_dir']) $dirs[] = $list[$i];
        else $files[] = $list[$i];
    }
    quicksort($dirs, 0, sizeof($dirs) - 1, $key);
    if ($reverse) $dirs = array_reverse($dirs);

    quicksort($files, 0, sizeof($files) - 1, $key);
    if ($reverse) $files = array_reverse($files);

    return array_merge($dirs, $files);
}

function quicksort (&$array, $first, $last, $key) {
    if ($first < $last) {
        $cmp = $array[floor(($first + $last) / 2)][$key];
        $l = $first;
        $r = $last;

        while ($l <= $r) {
            while ($array[$l][$key] < $cmp) $l++;
            while ($array[$r][$key] > $cmp) $r--;
            if ($l <= $r) {
                $tmp = $array[$l];
                $array[$l] = $array[$r];
                $array[$r] = $tmp;
                $l++;
                $r--;
            }
        }
        quicksort($array, $first, $r, $key);
        quicksort($array, $l, $last, $key);
    }
}

function permission_octal2string ($mode) {
    if (($mode & 0xC000) === 0xC000) {
        $type = 's';
    } elseif (($mode & 0xA000) === 0xA000) {
        $type = 'l';
    } elseif (($mode & 0x8000) === 0x8000) {
        $type = '-';
    } elseif (($mode & 0x6000) === 0x6000) {
        $type = 'b';
    } elseif (($mode & 0x4000) === 0x4000) {
        $type = 'd';
    } elseif (($mode & 0x2000) === 0x2000) {
        $type = 'c';
    } elseif (($mode & 0x1000) === 0x1000) {
        $type = 'p';
    } else {
        $type = '?';
    }

    $owner  = ($mode & 00400) ? 'r' : '-';
    $owner .= ($mode & 00200) ? 'w' : '-';
    if ($mode & 0x800) {
        $owner .= ($mode & 00100) ? 's' : 'S';
    } else {
        $owner .= ($mode & 00100) ? 'x' : '-';
    }

    $group  = ($mode & 00040) ? 'r' : '-';
    $group .= ($mode & 00020) ? 'w' : '-';
    if ($mode & 0x400) {
        $group .= ($mode & 00010) ? 's' : 'S';
    } else {
        $group .= ($mode & 00010) ? 'x' : '-';
    }

    $other  = ($mode & 00004) ? 'r' : '-';
    $other .= ($mode & 00002) ? 'w' : '-';
    if ($mode & 0x200) {
        $other .= ($mode & 00001) ? 't' : 'T';
    } else {
        $other .= ($mode & 00001) ? 'x' : '-';
    }

    return $type . $owner . $group . $other;
}

function is_script ($filename) {
    return ereg('\.php$|\.php3$|\.php4$|\.php5$', $filename);
}

function getmimetype ($filename) {
    static $mimes = array(
        '\.jpg$|\.jpeg$'  => 'image/jpeg',
        '\.gif$'          => 'image/gif',
        '\.png$'          => 'image/png',
        '\.html$|\.html$' => 'text/html',
        '\.txt$|\.asc$'   => 'text/plain',
        '\.xml$|\.xsl$'   => 'application/xml',
        '\.pdf$'          => 'application/pdf'
    );

    foreach ($mimes as $regex => $mime) {
        if (eregi($regex, $filename)) return $mime;
    }

    // return 'application/octet-stream';
    return 'text/plain';
}

function del ($file) {
    global $delim;

    if (!file_exists($file)) return false;
    if (@is_dir($file) && !@is_link($file)) {
        $success = false;
        if (@rmdir($file)) {

            $success = true;

        } elseif ($dir = @opendir($file)) {

            $success = true;

            while (($f = readdir($dir)) !== false) {
                if ($f != '.' && $f != '..' && !del($file . $delim . $f)) {
                    $success = false;
                }
            }
            closedir($dir);
            if ($success) $success = @rmdir($file);
        }
        return $success;
    }
    return @unlink($file);
}

function addslash ($directory) {
    global $delim;
    if (substr($directory, -1, 1) != $delim) {
        return $directory . $delim;
    } else {
        return $directory;
    }
}

function relative2absolute ($string, $directory) {
    if (path_is_relative($string)) {
        return simplify_path(addslash($directory) . $string);
    } else {
        return simplify_path($string);
    }
}

function path_is_relative ($path) {
    global $win;
    if ($win) {
        return (substr($path, 1, 1) != ':');
    } else {
        return (substr($path, 0, 1) != '/');
    }
}

function absolute2relative ($directory, $target) {
    global $delim;
    $path = '';
    while ($directory != $target) {
        if ($directory == substr($target, 0, strlen($directory))) {
            $path .= substr($target, strlen($directory));
            break;
        } else {
            $path .= '..' . $delim;
            $directory = substr($directory, 0, strrpos(substr($directory, 0, -1), $delim) + 1);
        }
    }
    if ($path == '') $path = '.';
    return $path;
}

function simplify_path ($path) {
    global $delim;
    if (@file_exists($path) && function_exists('realpath') && @realpath($path) != '') {
        $path = realpath($path);
        if (@is_dir($path)) {
            return addslash($path);
        } else {
            return $path;
        }
    }
    $pattern  = $delim . '.' . $delim;
    if (@is_dir($path)) {
        $path = addslash($path);
    }
    while (strpos($path, $pattern) !== false) {
        $path = str_replace($pattern, $delim, $path);
    }
    $e = addslashes($delim);
    $regex = $e . '((\.[^\.' . $e . '][^' . $e . ']*)|(\.\.[^' . $e . ']+)|([^\.][^' . $e . ']*))' . $e . '\.\.' . $e;
    while (ereg($regex, $path)) {
        $path = ereg_replace($regex, $delim, $path);
    }
    return $path;
}

function byteConvert(&$bytes){
        $b = (int)$bytes;
        $s = array('  B', 'KB', 'MB', 'GB', 'TB');
        if($b <= 0){
            return "0 ".$s[0];
        }
        $con = 1024;
        $e = (int)(log($b,$con));
        return number_format($b/pow($con,$e),2,',','.').' '.$s[$e];
}

function strip (&$str) {
    $str = stripslashes($str);
}

/* ------------------------------------------------------------------------- */
function listing_page ($message = null) {
    global $self, $directory, $sort, $reverse;
    html_header();
    $list = getlist($directory);
    if (array_key_exists('sort', $_GET)) $sort = $_GET['sort']; else $sort = 'filename';
    if (array_key_exists('reverse', $_GET) && $_GET['reverse'] == 'true') $reverse = true; else $reverse = false;
    echo '<h1 style="margin-bottom: 0"><a href="FileManager.php">File Manager</a></h1>
<form enctype="multipart/form-data" action="' . $self . '" method="post">
<table id="main" >';
    directory_choice();
    if (@is_writable($directory)) {
        upload_box();
        create_box();
    } else {
        spacer();
    }
    if (!empty($message)) {
        spacer();
        echo $message;
    }
    echo '</table><table id="tblContent"';
    if ($list) {
        $list = sortlist($list, $sort, $reverse);
        listing($list);
    } else {
        echo error('not_readable', $directory);
    }
    echo '</table></form>';
    html_footer();
}

function listing ($list) {
    global $directory, $homedir, $sort, $reverse, $win, $cols, $date_format, $self;
    echo '<tr class="titleContent">
    <td style="text-align: center; vertical-align: middle"><img src="' . $self . '?image=smiley" alt="smiley" /></td>';
    column_title('filename', $sort, $reverse);
    column_title('size', $sort, $reverse);
    if (!$win) {
        column_title('permission', $sort, $reverse);
        column_title('owner', $sort, $reverse);
        column_title('group', $sort, $reverse);
    }
    echo '    <td class="functions">' . word('functions') . '</td></tr>';
    for ($i = 0; $i < sizeof($list); $i++) {
        $file = $list[$i];
        $timestamps  = 'mtime: ' . date($date_format, $file['mtime']) . ', ';
        $timestamps .= 'atime: ' . date($date_format, $file['atime']) . ', ';
        $timestamps .= 'ctime: ' . date($date_format, $file['ctime']);
        echo '<tr class="listing">
    <td class="checkbox"><input type="checkbox" name="checked' . $i . '" value="true" onfocus="activate(\'other\')" /></td>
    <td class="filename" title="' . html($timestamps) . '">';
        if ($file['is_link']) {
            echo '<img src="' . $self . '?image=link" alt="link" /> ';
            echo html($file['filename']) . ' &rarr; ';
            $real_file = relative2absolute($file['target'], $directory);
            if (@is_readable($real_file)) {
                if (@is_dir($real_file)) {
                    echo '[ <a href="' . $self . '?dir=' . urlencode($real_file) . '">' . html($file['target']) . '</a> ]';
                } else {
                    echo '<a href="' . $self . '?action=view&amp;file=' . urlencode($real_file) . '">' . html($file['target']) . '</a>';
                }
            } else {
                echo html($file['target']);
            }
        } elseif ($file['is_dir']) {
            echo '<img src="' . $self . '?image=folder" alt="folder" /> [ ';
            if ($win || $file['is_executable']) {
                echo '<a href="' . $self . '?dir=' . urlencode($file['path']) . '">' . html($file['filename']) . '</a>';
            } else {
                echo html($file['filename']);
            }
            echo ' ]';
        } else {
            if (substr($file['filename'], 0, 1) == '.') {
                echo '<img src="' . $self . '?image=hidden_file" alt="hidden file" /> ';
            } else {
                echo '<img src="' . $self . '?image=file" alt="file" /> ';
            }
            if ($file['is_file'] && $file['is_readable']) {
               echo '<a href="' . $self . '?action=view&amp;file=' . urlencode($file['path']) . '" target="_blank">' . html($file['filename']) . '</a>';
            } else {
                echo html($file['filename']);
            }
        }
        if ($file['size'] >= 1000) {
            $human = ' title="' . byteConvert($file['size']) . '"';
        } else {
            $human = '';
        }
        echo "</td>\n";
        echo "\t<td class=\"size\"$human>". byteConvert($file['size']). "</td>\n";
        if (!$win) {
            echo "\t<td class=\"permission\" title=\"" . decoct($file['permission']) . '">';
            $l = !$file['is_link'] && (!function_exists('posix_getuid') || $file['owner'] == posix_getuid());
            if ($l) echo '<a href="' . $self . '?action=permission&amp;file=' . urlencode($file['path']) . '&amp;dir=' . urlencode($directory) . '">';
            echo html(permission_octal2string($file['permission']));
            if ($l) echo '</a>';
            echo "</td>\n";
            if (array_key_exists('owner_name', $file)) {
                echo "\t<td class=\"owner\" title=\"uid: {$file['owner']}\">{$file['owner_name']}</td>\n";
            } else {
                echo "\t<td class=\"owner\">{$file['owner']}</td>\n";
            }
            if (array_key_exists('group_name', $file)) {
                echo "\t<td class=\"group\" title=\"gid: {$file['group']}\">{$file['group_name']}</td>\n";
            } else {
                echo "\t<td class=\"group\">{$file['group']}</td>\n";
            }
        }
        echo '    <td class="functions"><input type="hidden" name="file' . $i . '" value="' . html($file['path']) . '" />';
        $actions = array();
        if (function_exists('symlink')) {
            $actions[] = 'create_symlink';
        }
        if (@is_writable(dirname($file['path']))) {
            $actions[] = 'delete';
            $actions[] = 'rename';
            $actions[] = 'move';
        }
        if ($file['is_file'] && $file['is_readable']) {
            $actions[] = 'copy';
            $actions[] = 'download';
            if ($file['is_writable']) $actions[] = 'edit';
        }
        if (!$win && function_exists('exec') && $file['is_file'] && $file['is_executable'] && file_exists('/bin/sh')) {
            $actions[] = 'execute';
        }
        if (sizeof($actions) > 0) {
            echo '<select name="action' . $i . '" size="1"><option value="">' . str_repeat('&nbsp;', 30) . '</option>';
            foreach ($actions as $action) {
                echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
            }
            echo '</select>&nbsp;<input type="submit" name="submit' . $i . '" value=" Next " onfocus="activate(\'other\')" />';
        }
        echo '    </td></tr>';
    }
    echo '<tr class="listing_footer">
    <td style="text-align: right; vertical-align: top"><img src="' . $self . '?image=arrow" alt="&gt;" /></td>
    <td colspan="' . ($cols - 1) . '">
    <input type="hidden" name="num" value="' . sizeof($list) . '" />
    <input type="hidden" name="focus" value="" />
    <input type="hidden" name="olddir" value="' . html($directory) . '" />';
    $actions = array();
    if (@is_writable(dirname($file['path']))) {
        $actions[] = 'delete';
        $actions[] = 'move';
    }
    $actions[] = 'copy';
    echo '        <select name="action_all" size="1">
        <option value="">' . str_repeat('&nbsp;', 30) . '</option>';
    foreach ($actions as $action) {
        echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
    }
    echo '        </select>
        <input type="submit" name="submit_all" value=" Next " onfocus="activate(\'other\')" /></td></tr>';
}

function column_title ($column, $sort, $reverse) {
    global $self, $directory;
    $d = 'dir=' . urlencode($directory) . '&amp;';
    $arr = '';
    $r = '';
    if ($sort == $column) {
        if (!$reverse) {
            $r = '&amp;reverse=true';
            $arr = ' &and;';
        } else {
            $arr = ' &or;';
        }
    } else {
        $r = '';
    }
    echo "\t<td class=\"$column\"><a href=\"$self?{$d}sort=$column$r\">" . word($column) . "</a>$arr</td>\n";
}

function directory_choice () {
    global $directory, $homedir, $cols, $self;
    echo '<tr>
    <td colspan="' . $cols . '" id="directory">
        <a href="' . $self . '?dir=' . urlencode($homedir) . '">' . word('directory') . '</a>:
        <input type="text" id="mytxt" class="mytxtDirectory" name="dir" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" onfocus="activate(\'directory\')" />
        <input type="submit" id="mybtn" name="changedir" value="' . word('change') . '" onfocus="activate(\'directory\')" />
    </td></tr>';
}

function upload_box () {
    global $cols;
    echo '<tr>
    <td colspan="' . $cols . '" id="upload">
        ' . word('file') . ':
        <input type="file" name="upload" size="70" onfocus="activate(\'other\')" />
        ' . word('newname') . ': <input type="text" name="newName" size="18" />
        <input type="submit" class="mybtnUpload" name="submit_upload" value="' . word('upload') . '" onfocus="activate(\'other\')" />
    </td></tr>';
}

function create_box () {
    global $cols;
    echo '<tr>
    <td colspan="' . $cols . '" id="create">
        <select name="create_type" size="1" onfocus="activate(\'create\')">
            <option value="file">' . word('file') . '</option>
            <option value="directory">' . word('directory') . '</option>
        </select>
        <input type="text" id="mytxt" name="create_name" size="30" onfocus="activate(\'create\')" />
        <input type="submit" id="mybtn" name="submit_create" value="' . word('create') . '" onfocus="activate(\'create\')" />
    </td></tr>';
}

function edit ($file) {
    global $self, $directory, $editcols, $editrows, $apache, $htpasswd, $htaccess;
    html_header();
    echo '<h2 style="margin-bottom: 3pt">' . html($file) . '</h2>
<form action="' . $self . '" method="post">
<table class="dialog">
<tr><td class="dialog">
    <textarea name="content" cols="' . $editcols . '" rows="' . $editrows . '" WRAP="off">';
    if (array_key_exists('content', $_POST)) {
        echo $_POST['content'];
    } else {
        $f = fopen($file, 'r');
        while (!feof($f)) {
            echo html(fread($f, 8192));
        }
        fclose($f);
    }
    if (!empty($_POST['user'])) {
        echo "\n" . $_POST['user'] . ':' . crypt($_POST['password']);
    }
    if (!empty($_POST['basic_auth'])) {
        if ($win) {
            $authfile = str_replace('\\', '/', $directory) . $htpasswd;
        } else {
            $authfile = $directory . $htpasswd;
        }
        echo "\nAuthType Basic\nAuthName &quot;Restricted Directory&quot;\n";
        echo 'AuthUserFile &quot;' . html($authfile) . "&quot;\n";
        echo 'Require valid-user';
    }
    echo '</textarea><hr />';
    if ($apache && basename($file) == $htpasswd) {
        echo '
    ' . word('user') . ': <input type="text" name="user" />
    ' . word('password') . ': <input type="password" name="password" />
    <input type="submit" value="' . word('add') . '" /><hr />';
    }
    if ($apache && basename($file) == $htaccess) {
        echo '
    <input type="submit" name="basic_auth" value="' . word('add_basic_auth') . '" /><hr />';
    }
    echo '
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="file" value="' . html($file) . '" />
    <input type="hidden" name="dir" value="' . html($directory) . '" />
    <input type="submit" name="save" value="' . word('save') . '" id="green_button" />
    <input type="reset" value="' . word('reset') . '" id="red_button" style="margin-left: 50px" />
</td></tr></table>
<p><a href="' . $self . '?dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p></form>';
    html_footer();
}

function spacer () {
    global $cols;
    echo '<tr><td colspan="' . $cols . '" style="height: 1em"></td></tr>';
}

function textfieldsize ($content) {
    $size = strlen($content) + 5;
    if ($size < 30) $size = 30;
    return $size;
}

function request_dump () {
    foreach ($_REQUEST as $key => $value) {
        echo "\t<input type=\"hidden\" name=\"" . html($key) . '" value="' . html($value) . "\" />\n";
    }
}

/* ------------------------------------------------------------------------- */
function html ($string) {
    global $site_charset;
    return htmlentities($string, ENT_COMPAT, $site_charset);
}

function word ($word) {
    global $words, $word_charset;
    return htmlentities($words[$word], ENT_COMPAT, $word_charset);
}

function phrase ($phrase, $arguments) {
    global $words;
    static $search;
    if (!is_array($search)) for ($i = 1; $i <= 8; $i++) $search[] = "%$i";
    for ($i = 0; $i < sizeof($arguments); $i++) {
        $arguments[$i] = nl2br(html($arguments[$i]));
    }
    $replace = array('{' => '<pre>', '}' =>'</pre>', '[' => '<b>', ']' => '</b>');
    return str_replace($search, $arguments, str_replace(array_keys($replace), $replace, nl2br(html($words[$phrase]))));
}

function getwords ($lang) {
    global $word_charset, $date_format;
    $date_format = 'n/j/y H:i:s';
    $word_charset = 'ISO-8859-1';
    return array(
        'directory' => 'Directory',
        'file' => 'File',
        'newname' => 'New name',
        'filename' => 'File name',
        'size' => 'Size',
        'permission' => 'Permission',
        'owner' => 'Owner',
        'group' => 'Group',
        'other' => 'Others',
        'functions' => 'Functions',
        'read' => 'Read',
        'write' => 'Write',
        'execute' => 'Execute',
        'create_symlink' => 'Create symlink',
        'delete' => 'Delete',
        'rename' => 'Rename',
        'move' => 'Move',
        'copy' => 'Copy',
        'edit' => 'Edit',
        'download' => 'Download',
        'upload' => 'Upload',
        'create' => 'Create',
        'change' => 'Change',
        'save' => 'Save',
        'set' => 'Set',
        'reset' => 'Reset',
        'relative' => 'Relative path to target',
        'yes' => 'Yes',
        'no' => 'No',
        'back' => 'Back',
        'destination' => 'Destination',
        'symlink' => 'Symlink',
        'no_output' => 'No output',
        'user' => 'User',
        'password' => 'Password',
        'add' => 'Add',
        'add_basic_auth' => 'Add basic-authentification',
        'uploaded' => '"[%1]" has been uploaded.',
        'not_uploaded' => '"[%1]" could not be uploaded.',
        'already_exists' => '"[%1]" already exists.',
        'created' => '"[%1]" has been created.',
        'not_created' => '"[%1]" could not be created.',
        'really_delete' => 'Delete these files?',
        'deleted' => "These files have been deleted:\n[%1]",
        'not_deleted' => "These files could not be deleted:\n[%1]",
        'rename_file' => 'Rename file:',
        'renamed' => '"[%1]" has been renamed to "[%2]".',
        'not_renamed' => '"[%1] could not be renamed to "[%2]".',
        'move_files' => 'Move these files:',
        'moved' => "These files have been moved to \"[%2]\":\n[%1]",
        'not_moved' => "These files could not be moved to \"[%2]\":\n[%1]",
        'copy_files' => 'Copy these files:',
        'copied' => "These files have been copied to \"[%2]\":\n[%1]",
        'not_copied' => "These files could not be copied to \"[%2]\":\n[%1]",
        'not_edited' => '"[%1]" can not be edited.',
        'executed' => "\"[%1]\" has been executed successfully:\n{%2}",
        'not_executed' => "\"[%1]\" could not be executed successfully:\n{%2}",
        'saved' => '"[%1]" has been saved.',
        'not_saved' => '"[%1]" could not be saved.',
        'symlinked' => 'Symlink from "[%2]" to "[%1]" has been created.',
        'not_symlinked' => 'Symlink from "[%2]" to "[%1]" could not be created.',
        'permission_for' => 'Permission of "[%1]":',
        'permission_set' => 'Permission of "[%1]" was set to [%2].',
        'permission_not_set' => 'Permission of "[%1]" could not be set to [%2].',
        'not_readable' => '"[%1]" can not be read.'
    );
}

function getimage ($image) {
    switch ($image) {
    case 'file':
        return base64_decode('R0lGODlhEQANAJEDAJmZmf///wAAAP///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA');
    case 'folder':
        return base64_decode('R0lGODlhEQANAJEDAJmZmf///8zMzP///yH5BAHoAwMALAAAAAARAA0AAAIqnI+ZwKwbYgTPtIudlbwLOgCBQJYmCYrn+m3smY5vGc+0a7dhjh7ZbygAADsA');
    case 'hidden_file':
        return base64_decode('R0lGODlhEQANAJEDAMwAAP///5mZmf///yH5BAHoAwMALAAAAAARAA0AAAItnIGJxg0B42rsiSvCA/REmXQWhmnih3LUSGaqg35vFbSXucbSabunjnMohq8CADsA');
    case 'link':
        return base64_decode('R0lGODlhEQANAKIEAJmZmf///wAAAMwAAP///wAAAAAAAAAAACH5BAHoAwQALAAAAAARAA0AAAM5SArcrDCCQOuLcIotwgTYUllNOA0DxXkmhY4shM5zsMUKTY8gNgUvW6cnAaZgxMyIM2zBLCaHlJgAADsA');
    case 'smiley':
        return base64_decode('R0lGODlhEQANAJECAAAAAP//AP///wAAACH5BAHoAwIALAAAAAARAA0AAAIslI+pAu2wDAiz0jWD3hqmBzZf1VCleJQch0rkdnppB3dKZuIygrMRE/oJDwUAOwA=');
    case 'arrow':
        return base64_decode('R0lGODlhEQANAIABAAAAAP///yH5BAEKAAEALAAAAAARAA0AAAIdjA9wy6gNQ4pwUmav0yvn+hhJiI3mCJ6otrIkxxQAOw==');
    }
}

function html_header () {
    global $site_charset;
    echo <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=$site_charset" />
<title>File Manager</title>
<style type="text/css">
body { font-size: 18px; text-align: center; background-color: #CCC; }
img { width: 17px; height: 13px }
a, a:visited { text-decoration: none; color: blue; }
hr { border-style: none; height: 1px; background-color: silver; color: silver }
#main { width: 1024px; border: 1px solid #000000; margin-top: 6pt; margin-left: auto; margin-right: auto; border-spacing: 3px;}
#main th { background: #eee; padding: 3pt 3pt 0pt 3pt }
.listing th, .listing td { padding: 1px 3pt 0 3pt }
.listing th { border: 1px solid silver }
.listing td { border: 1px solid #BFBFBF; }
.listing .checkbox { text-align: center }
.listing .filename { text-align: left }
.listing .size { text-align: right }
.listing th.permission { text-align: left }
.listing td.permission { font-family: monospace }
.listing .owner { text-align: center; }
.listing .group { text-align: center }
.listing .functions { text-align: center }
.listing_footer td { background: #eee; border: 1px solid silver }
#directory, #upload, #create, .listing_footer td, #error td, #notice td { text-align: left; padding: 3pt }
#directory { border: 1px solid #000000; height: 50px; }
#upload { border: 1px solid #000000; height: 50px; }
#create { border: 1px solid #000000; height: 50px; }
textarea { border: none; background: white }
table.dialog { margin-left: auto; margin-right: auto }
td.dialog { background: #eee; padding: 1ex; border: 1px solid silver; text-align: center }
#permission { margin-left: auto; margin-right: auto }
#permission td { padding-left: 3pt; padding-right: 3pt; text-align: center }
td.permission_action { text-align: right }
#symlink { background: #eee; border: 1px solid silver }
#symlink td { text-align: left; padding: 3pt }
#red_button { width: 120px; color: #400 }
#green_button { width: 120px; color: #040 }
#error td { background: maroon; color: white; border: 1px solid silver }
#notice td { background: green; color: white; border: 1px solid silver }
#notice pre, #error pre { background: silver; color: black; padding: 1ex; margin-left: 1ex; margin-right: 1ex }
code { font-size: 12pt }
td { white-space: nowrap;}
.titleContent td { border: 1px solid #ddd; background: #999999; }
#tblContent { width: 1024px; margin-top: 10pt; margin-left: auto; margin-right: auto; border: 1px solid #000000; border-spacing: 0px; }
#tblContent tr { background: #FAFAFA; }
#tblContent tr:hover{ background-color: #C8C8C8; }
input { font-size: 16px; }
select { font-size: 16px; border: 1px solid #666; height: 27px; }
#mytxt { border: 1px solid #666; height: 27px; }
#mybtn { height: 32px; font-weight: bold; }
.mytxtDirectory { width: 700px; }
.mybtnUpload { font-weight: bold; }
</style>

<script type="text/javascript">
<!--
function activate (name) {
    if (document && document.forms[0] && document.forms[0].elements['focus']) {
        document.forms[0].elements['focus'].value = name;
    }
}
//-->
</script>

</head>
<body>
END;
}

function html_footer () {
    echo <<<END
</body>
</html>
END;
}

function notice ($phrase) {
    global $cols;
    $args = func_get_args();
    array_shift($args);
    return '<tr id="notice"><td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td></tr>';
}

function error ($phrase) {
    global $cols;
    $args = func_get_args();
    array_shift($args);
    return '<tr id="error">
    <td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td></tr>';
}
?>